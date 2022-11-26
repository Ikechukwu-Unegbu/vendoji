<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\transactions\Wallet;
use App\Notifications\NewWalletNotification;
use App\Notifications\WalletNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
class WalletController extends Controller
{
    public function bitcoinApiClient($method, $apiLink)
    {
        $client = new Client();
        $request = $client->request($method, $apiLink, [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'http_errors' => false
        ]);
        return $request;
    }

    public function wallets()
    {
        if(request()->wantsJson())
        {
            try {
                $wallets = Wallet::whereUserId(auth()->user()->id)->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Wallet Fetched Successfully',
                    'data'  =>  $wallets
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' =>  'User Not Found!', 'data' => [] ], 404);
            }
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function newWallet(Request $request)
    {
        if ($request->wantsJson())
        {
            try {
                $validator = Validator::make($request->all(), [
                    'coin_type' => 'required',
                    'password' => 'required|string|min:4'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                else {
                    try {
                        if ($request->coin_type == 'btc') {
                            $apiKey = env('Bitcoin_Api');
                        } elseif ($request->coin_type == 'doge') {
                            $apiKey = env('Dogecoin_Api');
                        } elseif ($request->coin_type == 'lite') {
                            $apiKey = env('Litecoin_Api');
                        } else {
                            $apiKey = null;
                        }
                        $label = auth()->user()->email;
                        $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_new_address/?api_key={$apiKey}&label={$label}")->getBody(), true);
                        if($wallet['status'] === 'success'){
                            $address = $wallet['data']['address'];
                            $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
                            $availableBalance = $balance['data']['available_balance'];
                            $newWallet = Wallet::create([
                                'user_id' => auth()->user()->id,
                                'password' => bcrypt($request->password),
                                'pass_phrase' => $address,
                                'balance' => $availableBalance,
                                'coin_type' => $request->coin_type
                            ]);
                            activity()->log('wallet created successfully')->causer(auth()->user()->id);
                            $admins = User::whereAccess('admin')->get();
                            Notification::sendNow($admins, new NewWalletNotification(auth()->user()));
                            return response()->json(['status' => true, 'message' => 'Wallet Created Successfully', 'data' => $newWallet]);
                        } elseif($wallet['status'] === 'fail') {
                            activity()->log('error while creating wallet')->causer(auth()->user()->id);
                            return response()->json(['status' => false, 'message' => "Wallet {$request->coin_type} already exists!", 'data' => []]);
                        }

                        return response()->json(['status' => false, 'message' => "Error while creating new Wallet", 'data' => []]);
                    } catch(\Exception $e) {
                        return response()->json(['status' => false, 'message' => "{$e->getMessage()}", 'data' => []]);
                    }
                }
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' =>  $e->getMessage(), 'data' => [] ], 500);
            }
        }
        else {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }
}

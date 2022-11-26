<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\transactions\Wallet;
use App\Notifications\FailedWalletNotification;
use App\Notifications\NewWalletNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        $wallets = Wallet::latest()->get();
        $users = User::orderBy('name', 'ASC')->get();
        return view('admin.wallet.index', ['wallets' => $wallets, 'users' => $users]);
    }

    public function getWalletBalance()
    {
        $bitcoinApiKey = env('Bitcoin_Api');
        $litecoinApiKey = env('Litecoin_Api');
        $dogecoinApiKey = env('Dogecoin_Api');
        $wallets = Wallet::with('user')->latest()->get();
        foreach($wallets as $wallet)
        {
            try{
                $address = $wallet->pass_phrase ?? '';
                if($wallet->coin_type == 'btc') {
                    $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$bitcoinApiKey}&addresses={$address}")->getBody(), true);
                } elseif ($wallet->coin_type == 'lite') {
                    $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$litecoinApiKey}&addresses={$address}")->getBody(), true);
                } elseif ($wallet->coin_type == 'lite') {
                    $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$dogecoinApiKey}&addresses={$address}")->getBody(), true);
                }
                $availableBalance = $balance['data']['available_balance'];

                $wallet->update(['balance' => $availableBalance]);
            }catch (\Exception $e){
                // session()->flash('failed', $e->getMessage());
            }
        }

        return response()->json(['status' => true, 'message' => 'Wallet Fetched Successfully', 'data' => $wallets]);
    }



    public function search()
    {
        request()->validate([
            'option' => 'required',
            'search' => 'required',
        ]);

        if(request()->option == 'user') {
            $search = request()->search;
            $users = User::with('wallets')->where('name', 'LIKE', "%{$search}%")->pluck( 'id')->toArray();
            $wallets = Wallet::with('user')->whereIn('user_id', $users)->get();
            return response()->json(['status' => true, 'message' => 'user wallets fetched successfully', 'data' => $wallets]);
        } elseif(request()->option == 'wallet'){
            $search = request()->search;
            $wallets = Wallet::with('user')->where('coin_type', 'LIKE', "%{$search}%")->get();
            return response()->json(['status' => true, 'message' => 'user wallets fetched successfully', 'data' => $wallets]);
        } else {
            return response()->json(['status' => false, 'message' => 'user wallets not found', 'data' => []]);
        }

        return response()->json(['option' => request()->option, 'search' => request()->search]);
    }

    public function adminCreateWalletForUser()
    {
        request()->validate( [
            'user' => 'required',
            'coin' => 'required',
            'password' => 'required|string|min:4'
        ]);

        try {
            if (request()->coin == 'btc') {
                $apiKey = env('Bitcoin_Api');
            } elseif (request()->coin == 'doge') {
                $apiKey = env('Dogecoin_Api');
            } elseif (request()->coin == 'lite') {
                $apiKey = env('Litecoin_Api');
            } else {
                $apiKey = null;
            }
            $user = User::whereId(request()->user)->first();
            $admins = User::whereAccess('admin')->get();
            if(!empty($user->id)){
                $label = $user->email;
                $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_new_address/?api_key={$apiKey}&label={$label}")->getBody(), true);
                if($wallet['status'] === 'success'){
                    $address = $wallet['data']['address'];
                    $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
                    $availableBalance = $balance['data']['available_balance'];
                    Wallet::create([
                        'user_id' => $user->id,
                        'password' => bcrypt(request()->password),
                        'pass_phrase' => $address,
                        'balance' => $availableBalance,
                        'coin_type' => request()->coin
                    ]);
                    activity()->log('wallet created successfully')->causer($user->id);

                    Notification::sendNow($admins, new NewWalletNotification($user, "New Wallet Created ({$user->name})"));
                    session()->flash('success', "Wallet Created Successfully");
                    return redirect()->back();
                } elseif($wallet['status'] === 'fail') {
                    Notification::sendNow($admins, new NewWalletNotification(auth()->user(), 'Wallet '.request()->coin.' already exists for user ('.auth()->user()->name.')' ));
                    activity()->log('Wallet '.request()->coin.' already exists for this user!')->causer(Auth::id());
                    session()->flash('error', 'Wallet '.request()->coin.' already exists for this user!');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', "User not Found!");
                return redirect()->back();
            }

            session()->flash('error', 'Error while creating');
            return redirect()->back();
        } catch(\Exception $e) {
            session()->flash('error', "{$e->getMessage()}");
            return redirect()->back();
        }
    }
}

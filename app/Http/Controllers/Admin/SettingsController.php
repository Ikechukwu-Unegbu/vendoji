<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\V1\transactions\Wallet;
use App\Models\WalletTransaction;
use App\Notifications\NewWalletNotification;
use App\Notifications\WalletNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class SettingsController extends Controller
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

    public function masterWallets()
    {
        $wallets  = SiteSetting::get();
        $users = User::orderBy('name')->get();
        // dd($wallets->count());
        if($wallets->count() == 0){

            $apiKeys = ['btc' => env('Bitcoin_Api'), 'lite' => env('Litecoin_Api'), 'doge' => env('Dogecoin_Api')];

            $label = 'default';
            try {
                foreach($apiKeys as $key => $apiKey) {
                    $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_by/?api_key={$apiKey}&label={$label}")->getBody());
                    SiteSetting::create([
                        'user_id' => auth()->user()->id,
                        'password' => auth()->user()->password,
                        'pass_phrase' => $wallet->data->address,
                        'balance' => $wallet->data->available_balance,
                        'coin_type' => $key
                    ]);
                }
                return view('admin.setting.coin', ['wallets' => $wallets, 'users' =>  $users]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }



        return view('admin.setting.coin', ['wallets' => $wallets, 'users' =>  $users]);
    }

    public function masterCoinTransfer(Request $request)
    {
        request()->validate([
            'address'    =>  'required',
            'coin_address'  =>  'required',
            'amount'    =>  'required',
            'password'  =>  'required'
        ]);

        if(auth()->user()->access == 'admin') {

            try{
                $wallet = SiteSetting::with('user')->whereId(request()->address)->first();
                $checkWalletPassword = Hash::check(request()->password, $wallet->password);
                $receiverWalletId = Wallet::with('user')->wherePassPhrase(request()->coin_address)->first();
                if(!empty($receiverWalletId->id))
                {
                    if(auth()->user()->id == $wallet->user_id && $checkWalletPassword) {

                        $apiKey = env('Bitcoin_Api');

                        $response = json_decode($this->bitcoinApiClient("GET", "https://block.io/api/v2/prepare_transaction/?api_key={$apiKey}&from_addresses={$wallet->pass_phrase}&to_addresses={$receiverWalletId->pass_phrase}&amounts={$request->amount}")->getBody());

                        if($response->status == 'fail'){
                            if(isset($response->data->minimum_balance_needed)) {
                                session()->flash('error', "{$response->data->error_message} Minimum balance needed {$response->data->minimum_balance_needed}");
                                $admins = User::whereAccess('admin')->get();
                                Notification::sendNow($admins, new NewWalletNotification($wallet->user, "Unable to Transfer Coin ({$wallet->user->name})"));
                                Notification::sendNow(auth()->user(), new NewWalletNotification($wallet->user, "{$response->data->error_message} Minimum balance needed {$response->data->minimum_balance_needed}"));
                                return redirect()->back();
                            } else {
                                session()->flash('error', "Wallet Address does not Exist!");
                                return redirect()->back();
                            }
                        } elseif ($response->status == 'success') {
                            WalletTransaction::create([
                                'sender_id' =>  $wallet->user_id,
                                'sender_wallet_id' =>  $wallet->id,
                                'receiver_id'   =>  $receiverWalletId->user_id,
                                'receiver_wallet_id'   =>  $receiverWalletId->id,
                                'amount'        =>  $request->amount,
                            ]);
                            //Save to DB
                            $senderWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$wallet->pass_phrase}")->getBody(), true);
                            $senderAvailableBalance = $senderWalletBalance['data']['available_balance'];
                            $wallet->update(['balance' => $senderAvailableBalance ?? 0.00]);

                            $receiverWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$receiverWalletId->pass_phrase}")->getBody(), true);
                            $receiverAvailableBalance = $receiverWalletBalance['data']['available_balance'];
                            $receiverWalletId->update(['balance' => $receiverAvailableBalance ?? 0.00]);
                            $admins = User::whereAccess('admin')->get();
                            Notification::sendNow($admins, new WalletNotification($wallet->user, $receiverWalletId->user, $request->amount));
                            Notification::sendNow(auth()->user(), new WalletNotification($wallet->user, $receiverWalletId->user, $request->amount));
                            Notification::sendNow($receiverWalletId->user, new WalletNotification($wallet->user, $receiverWalletId->user, $request->amount));
                            session()->flash('success', "Coin Transferred Successfully");
                            return redirect()->back();
                        }
                    } else {
                        session()->flash('error', 'Transfer Failed, Fraud Detected!');
                        return redirect()->back();
                    }
                }
                session()->flash('error', 'Receiver\'s Wallet Address not Found!');
                return redirect()->back();
            } catch(\Exception $e) {
                session()->flash('error', "{$e->getMessage()}");
                return redirect()->back();
            }
        } else {
            session()->flash('error', "Unauthorized!");
            return redirect()->back();
        }
    }
}

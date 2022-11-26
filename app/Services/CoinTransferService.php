<?php
namespace App\Services;

use App\Models\User;
use App\Models\V1\Core\Adminincome;
use App\Models\V1\transactions\Wallet;
use App\Models\WalletTransaction;
use App\Notifications\NewWalletNotification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WalletNotification;
use Illuminate\Support\Facades\Auth;

class CoinTransferService {

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



    public function transferBtc($btcAmount,Wallet $receiverWallet,Wallet $senderWallet, $coinType, $ref=false)
    {

        //check if the sender wallet have up to that amount, send session error message if not.
        $senderBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinType}&addresses={$senderWallet->pass_phrase}")->getBody());

        if($btcAmount <= 0) {
            session()->flash('failed', 'Transfer amounts cannot be less than 0.00001');
        }

        if($btcAmount > $senderBalance->data->available_balance)
        {
            session()->flash('failed', 'Approval failed due to Insufficient balance');
        }
        //proceed to send the btc
        else
        {
            $transferAction = json_decode($this->bitcoinApiClient("GET", "https://block.io/api/v2/prepare_transaction/?api_key={$coinType}&from_addresses={$senderWallet->pass_phrase}&to_addresses={$receiverWallet->pass_phrase}&amounts={$btcAmount}")->getBody());

            if(isset($transferAction->status)) {
                if($transferAction->status == 'success') {
                    //Save to DB
                    WalletTransaction::create([
                        'sender_id' =>  $senderWallet->user_id,
                        'sender_wallet_id' =>  $senderWallet->id,
                        'receiver_id'   =>  $receiverWallet->user_id,
                        'receiver_wallet_id'   =>  $receiverWallet->id,
                        'amount'        =>  $btcAmount,
                    ]);

                    $senderWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinType}&addresses={$senderWallet->pass_phrase}")->getBody(), true);
                    $senderAvailableBalance = $senderWalletBalance['data']['available_balance'];
                    $senderWallet->update(['balance' => $senderAvailableBalance ?? 0.00]);

                    $receiverWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinType}&addresses={$receiverWallet->pass_phrase}")->getBody(), true);
                    $receiverAvailableBalance = $receiverWalletBalance['data']['available_balance'];
                    $receiverWallet->update(['balance' => $receiverAvailableBalance ?? 0.00]);
                    //if succesffully sent, notify the recipient -- if $ref is set to true,
                    // modify the message to let the recipient know it is a referral reward
                    Notification::sendNow($receiverWallet->user, new NewWalletNotification($receiverWallet->user, "Received {$btcAmount}".strtoupper($senderWallet->coin_type)." from {$senderWallet->pass_phrase} to {$receiverWallet->pass_phrase}"));

                    Notification::sendNow($senderWallet->user, new NewWalletNotification($senderWallet->user, "Sent: {$btcAmount}".strtoupper($senderWallet->coin_type)." from {$senderWallet->pass_phrase} to {$receiverWallet->pass_phrase}"));
                    //return true for success or false for failure
                    activity()->log('coin transferred successfully')->causer(Auth::id());
                    session()->flash('success', "Coin Transferred Successfully");
                    return redirect()->back();
                } elseif($transferAction->status == 'fail') {
                    //if there is error in sending the btc notify the sender via session
                    activity()->log('coin transfer failed')->causer(Auth::id());
                    session()->flash('failed', "Approval Failed due to insufficient balance");
                    //notify the sender too
                    Notification::sendNow($senderWallet->user, new NewWalletNotification($senderWallet->user, "Transfer Unsuccessful! Minimum balance needed {$transferAction->data->minimum_balance_needed}".strtoupper($senderWallet->coin_type)));
                }
            }
            else {
                session()->flash('failed', 'Transaction Failed!');
            }
        }
    }

    public function walletTransaction($btcAmount, $receiverWallet, $senderWallet, $coinType, $adminEarning = 0, $ref=false)
    {
        if($coinType == 'btc') {
            $coinTypeApi = env('Bitcoin_Api');
        } elseif ($coinType == 'lite') {
            $coinTypeApi = env('Litecoin_Api');
        } elseif ($coinType == 'doge') {
            $coinTypeApi = env('Dogecoin_Api');
        } else {
            $coinTypeApi = null;
        }

        //check if the sender wallet have up to that amount, send session error message if not.
        $senderBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinTypeApi}&addresses={$senderWallet->pass_phrase}")->getBody());

        if($btcAmount <= 0) {
            session()->flash('failed', 'Transfer amounts cannot be less than 0.00001');
        }

        if($btcAmount > $senderBalance->data->available_balance)
        {
            session()->flash('failed', 'Approval failed due to Insufficient balance');
        }
        //proceed to send the btc
        else
        {
            //Admin Percentage Earning
            $removeAdminPercentage = $btcAmount - $adminEarning;
            $roundAmount = number_format($removeAdminPercentage, 8, '.', '');
            //

            $transferActionForReceiver = json_decode($this->bitcoinApiClient("GET", "https://block.io/api/v2/prepare_transaction/?api_key={$coinTypeApi}&from_addresses={$senderWallet->pass_phrase}&to_addresses={$receiverWallet->pass_phrase}&amounts={$roundAmount}")->getBody());

            $transferActionForAdmin = json_decode($this->bitcoinApiClient("GET", "https://block.io/api/v2/prepare_transaction/?api_key={$coinTypeApi}&from_addresses={$senderWallet->pass_phrase}&to_addresses={$receiverWallet->pass_phrase}&amounts={$adminEarning}")->getBody());

            if(isset($transferActionForReceiver->status)) {
                if($transferActionForReceiver->status == 'success') {
                    //Save to DB
                    WalletTransaction::create([
                        'sender_id' =>  $senderWallet->user_id,
                        'sender_wallet_id' =>  $senderWallet->id,
                        'receiver_id'   =>  $receiverWallet->user_id,
                        'receiver_wallet_id'   =>  $receiverWallet->id,
                        'amount'        =>  $btcAmount,
                    ]);

                    $senderWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinTypeApi}&addresses={$senderWallet->pass_phrase}")->getBody(), true);
                    $senderAvailableBalance = $senderWalletBalance['data']['available_balance'];
                    $senderWallet->update(['balance' => $senderAvailableBalance ?? 0.00]);

                    $receiverWalletBalance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$coinTypeApi}&addresses={$receiverWallet->pass_phrase}")->getBody(), true);
                    $receiverAvailableBalance = $receiverWalletBalance['data']['available_balance'];
                    $receiverWallet->update(['balance' => $receiverAvailableBalance ?? 0.00]);
                    //if succesffully sent, notify the recipient -- if $ref is set to true,
                    // modify the message to let the recipient know it is a referral reward
                    Notification::sendNow($receiverWallet->user, new NewWalletNotification($receiverWallet->user, "Received {$btcAmount}".strtoupper($senderWallet->coin_type)." from {$senderWallet->pass_phrase} to {$receiverWallet->pass_phrase}"));

                    Notification::sendNow($senderWallet->user, new NewWalletNotification($senderWallet->user, "Sent: {$btcAmount}".strtoupper($senderWallet->coin_type)." from {$senderWallet->pass_phrase} to {$receiverWallet->pass_phrase}"));
                    //return true for success or false for failure
                    activity()->log('coin transferred successfully')->causer(Auth::id());
                    session()->flash('success', "Coin Transferred Successfully");
                    return redirect()->back();
                } elseif($transferActionForReceiver->status == 'fail') {
                    dd($transferActionForReceiver);
                    // dd($transferActionForReceiver);
                    //if there is error in sending the btc notify the sender via session
                    activity()->log('Approval Failed due to insufficient balance')->causer(Auth::id());
                    session()->flash('failed', "Approval Failed due to insufficient balance");
                    //notify the sender too
                    Notification::sendNow($senderWallet->user, new NewWalletNotification($senderWallet->user, "Approval Failed due to insufficient balance"));
                }
            }

            if (isset($transferActionForReceiver->status)) {
                Adminincome::create([
                    'model_id'  =>  $senderWallet->user_id,
                    'cointype'  =>  $coinType,
                    'amount'    =>  $adminEarning,
                ]);
            }
            else {
                session()->flash('failed', 'Transaction Failed!');
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\Core\Lock;
use App\Models\V1\transactions\Wallet;
use App\Models\WalletTransaction;
use App\Notifications\NewWalletNotification;
use App\Notifications\WalletNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Services\CoinTransferService;
class WalletController extends Controller
{
    public function __construct(private CoinTransferService $coinTransferService)
    {
        // $this->coinTransferService = $cointransaction
    }

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

    public function walletIndex()
    {
        $user = auth()->user();
        $wallets = Wallet::whereUserId($user->id)->get();
        try{
            foreach($wallets as $wallet)
            {
                if ($wallet->coin_type == 'btc') {
                    $apiKey = env('Bitcoin_Api');
                } elseif ($wallet->coin_type == 'doge') {
                    $apiKey = env('Dogecoin_Api');
                } elseif ($wallet->coin_type == 'lite') {
                    $apiKey = env('Litecoin_Api');
                } else {
                    $apiKey = null;
                }
                $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$wallet->pass_phrase}")->getBody(), true);
                $availableBalance = $balance['data']['available_balance'];
                $wallet->update(['balance' => $availableBalance ?? 0.00]);
            }
        }catch (\Exception $e){
            session()->flash('failed', 'Error while fetching wallet balance');
        }
        //fetch locks
        $locks = Lock::all();
        return view('pages.wall.index', compact('wallets'))->with('locks', $locks);
    }

    public function newWallet()
    {
        $this->validate(request(), [
            'coin' => 'required',
            'password' => 'required|string|min:4'
        ]);
        $admins = User::whereAccess('admin')->get();
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
            $label = auth()->user()->email;
            $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_new_address/?api_key={$apiKey}&label={$label}")->getBody(), true);
            if($wallet['status'] === 'success'){
                $address = $wallet['data']['address'];
                $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
                $availableBalance = $balance['data']['available_balance'];
                Wallet::create([
                    'user_id' => auth()->user()->id,
                    'password' => bcrypt(request()->password),
                    'pass_phrase' => $address,
                    'balance' => $availableBalance,
                    'coin_type' => request()->coin
                ]);
                activity()->log('wallet created successfully')->causer(auth()->user()->id);

                Notification::sendNow($admins, new NewWalletNotification(auth()->user(), 'New Wallet Created ('.auth()->user()->name.')'));
                Notification::sendNow(auth()->user(), new NewWalletNotification(auth()->user(), 'New Wallet Created ('.auth()->user()->name.')'));
                session()->flash('success', "Wallet Created Successfully");
                return redirect()->back();
            } elseif($wallet['status'] === 'fail') {
                Notification::sendNow($admins, new NewWalletNotification(auth()->user(), 'Wallet '.strtoupper(request()->coin).' already exists for user ('.auth()->user()->name.')' ));
                Notification::sendNow(auth()->user(), new NewWalletNotification(auth()->user(), 'Wallet '.strtoupper(request()->coin).' already exists' ));
                activity()->log('Wallet '.strtoupper(request()->coin).' already exists!')->causer(Auth::id());
                session()->flash('failed', 'Wallet '.strtoupper(request()->coin).' already exists!');
                return redirect()->back();
            }

            session()->flash('failed', 'Error while creating Wallet');
            return redirect()->back();
        } catch(\Exception $e) {
            session()->flash('failed', "Connection could not be Established!");
            return redirect()->back();
        }
    }

    public function coinTransfer(Request $request)
    {
        $request->validate([
            'address'   =>  'required',
            'coin_address'  =>  'required',
            'amount'    =>  'required',
            'password'  =>  'required',
        ]);

        $sender = Wallet::whereId($request->address)->whereUserId(Auth::id())->first();
        $receiver = Wallet::wherePassPhrase($request->coin_address)->first();
        $senderPassword = Hash::check(request()->password, $sender->password);

        if(!$senderPassword) {
            session()->flash('failed', 'The provided password is incorrect');
            return redirect()->back();
        }

        if($sender->pass_phrase == $request->coin_address){
            session()->flash('failed', 'You cannot make Transfer to the same wallet address');
            return redirect()->back();
        }

        if(!$receiver) {
            session()->flash('failed', 'The Recipient Wallet Address does not Exist!');
            return redirect()->back();
        }

        if($sender->coin_type == 'btc') {
            $coinTypeApi = env('Bitcoin_Api');
        } elseif ($sender->coin_type == 'lite') {
            $coinTypeApi = env('Litecoin_Api');
        } elseif ($sender->coin_type == 'doge') {
            $coinTypeApi = env('Dogecoin_Api');
        } else {
            $coinTypeApi = null;
        }

        try{
            $this->coinTransferService->transferBtc($request->amount, $receiver, $sender, $coinTypeApi);

        } catch(\Exception $e) {
            session()->flash('failed', 'Coin Trasnfer Failed');
            return redirect()->back();
        }

        return redirect()->back();

    }
}

<?php

namespace App\Http\Controllers\Admin;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\V1\Bank\Bank;
use App\Models\V1\Bank\Banktransfer;
use App\Models\V1\Core\Adminincome;
use App\Models\V1\Core\Lock;
use App\Models\V1\Core\Refearning;
use App\Models\V1\Core\Refrule;
use App\Models\V1\Core\Userlock;
use App\Models\V1\transactions\Wallet;
use App\Services\CalculationService;
use App\Services\CoinTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class BanktransferController extends Controller
{
    public function userDebit($id){
        // var_dump(Auth::user()->id);die;
        if(auth()->user()->wallets->where('balance', '<=', 0)->count() > 0)
        {
            session()->flash('failed', 'You cannot apply for withdrawal due to Insufficient balance');
            return redirect()->route('dashboard');
        }
        return view('pages.bank.debit');
    }

    public function initDebit(Request $request, $id){
        $request->validate([
            'amount'=>'required|string',
            // 'locking_option'=>'required|string',
            'account_number'=>'required|string',
            'bank_name'=>'required|string',
            'account_name'=>'required|string',
            'password'  =>  'required|string',
            'coin'  =>  'required'
        ]);

        //Get User Lock Percentage



        if($request->coin !== 'btc' && $request->coin !== 'lite' && $request->coin !== 'doge') {
            Session::flash('failed', 'Fraud Detected!');
            return redirect()->back();
        }
        //Check User Password
        $checkPassword = Hash::check($request->password, auth()->user()->password);

        if(!$checkPassword) {
            Session::flash('failed', 'The provided password is incorrect');
            return redirect()->back();
        }

         //Check Wallet Balance
        $wallet = Wallet::whereUserId(Auth::id())->where('coin_type', $request->coin)->first();
        // if($wallet) {
        //     if($request->amount > $wallet->balance) {
        //         Session::flash('failed', 'Withdrawal Failed due to Insufficient balance');
        //         return redirect()->back();
        //     }
        // } else {
        //     Session::flash('failed', 'Wallet does not exist');
        //     return redirect()->back();
        // }

        $userWallet = auth()->user()->wallets->where('coin_type', $request->coin)->first();
        $userLock = auth()->user()->banktransfers->last()->percentage_lock;
        $currentBtcVal =  Currency::convert()->from('NGN')->to('BTC')->amount($request->amount)->date(now())->get();
        $roundConversion = number_format($currentBtcVal, 8, '.', '');
        $lockCalculation = (new CalculationService)->percentageLock($roundConversion, $userLock);
        $roundPercentageValue = number_format($lockCalculation, 8, '.', '');

        $userLockPercentage = 100 - $userLock;

        if($roundPercentageValue > $userWallet->balance){
            session()->flash('failed', "You cannot withdraw more than {$userLockPercentage}% from your available balance");
            return redirect()->back();
        }
        //store in db
        $banktransfer = new Banktransfer();
        $banktransfer->amount = $request->amount;
        // $banktransfer->locking_option = $request->locking_option;
        $banktransfer->account_number = $request->account_number;
        $banktransfer->account_name = $request->account_name;
        $banktransfer->bank_name = $request->bank_name;
        $banktransfer->type = 0;
        $banktransfer->user_id = Auth::user()->id;
        $banktransfer->coin_type = $request->coin;
        $banktransfer->save();

        Session::flash('success', 'Withdrawal details recorded.');
        return redirect()->route('debit.finale', [$banktransfer->id]);
        // dd($roundPercentageValue);
    }

    public function debitFinale($id){

        return view('pages.bank.debit_complete');
    }

    public function creditFinale($id){

        $bank = Bank::where('state', '1')->first();

        $banktransfer = Banktransfer::find($id);
        if($banktransfer->trxid == null){
            $rand = rand(1000, 9999).''.Str::random(4);
            $banktransfer->trxid = $rand;
            $banktransfer->save();
        }

        return view('pages.bank.credit_finale')->with('bank', $bank)->with('banktransfer', $banktransfer);
    }


    public function initCredit(Request $request, $id){
        $request->validate([
            'amount'=>'required|string',
            'wallet'=>'required',
            'locking_duration'=>'required',
            'locking_percentage'   =>   'required',
        ]);
        //
        // if($request->locking_duration == 'None' || $request->locing_duration == 0){
        //     Session::flash('failed', 'Please select locking duration.');
        //     return redirect()->back();
        // }

        if($request->wallet !== 'btc' && $request->wallet !== 'lite' && $request->wallet !== 'doge') {
            Session::flash('error', 'Unable to Process Transaction');
            return redirect()->back();
        }

        $banktransfer = new Banktransfer();
        $banktransfer->amount = $request->amount;
        $banktransfer->user_id = User::find($id)->id;
        $banktransfer->type = 1;
        $banktransfer->locking_duration = $request->locking_duration;
        $banktransfer->percentage_lock = $request->locking_percentage;
        $banktransfer->coin_type = $request->wallet;
        $banktransfer->save();

        Session::flash('success', 'done');
        return redirect()->route('credit.finale', [$banktransfer->id]);
    }

    public function adminBanktransferDebit(){
        $banktransfer = Banktransfer::where('type', '0')->paginate(30);
        $masterWallets = SiteSetting::get();
        $btc =  Currency::convert()
            ->from('BTC')
            ->to('NGN')
            ->amount(1)
            ->date(now())
              ->get();

              foreach($banktransfer as $trf){
                $cal = new CalculationService();
                $currentBtcVal =  Currency::convert()
                ->from('BTC')
                ->to('NGN')
                ->amount(1)
                ->date(now())
                  ->get();
                $x_btc = $cal->find_x_btc(1,$trf->amount, $currentBtcVal);
                $trf->valinbtc = $x_btc;
                $trf->rounded_btc_val = round($x_btc, 7);
            }

        return view('admin.bank.transfer.debit')->with('btc', $btc)->with('trnsfers', $banktransfer)->with('masterWallets', $masterWallets);
    }

    public function adminBanktransferCredit(){
        $banktransfer = Banktransfer::where('type', '1')->paginate(30);
        $masterWallets = SiteSetting::all();
        $btc =  Currency::convert()
            ->from('BTC')
            ->to('NGN')
            ->amount(1)
            ->date(now())
              ->get();

        foreach($banktransfer as $trf){
            $cal = new CalculationService();
            $currentBtcVal =  Currency::convert()
            ->from('BTC')
            ->to('NGN')
            ->amount(1)
            ->date(now())
              ->get();
            $x_btc = $cal->find_x_btc(1,$trf->amount, $currentBtcVal);
            $trf->valinbtc = $x_btc;
            $trf->rounded_btc_val = round($x_btc, 7);
        }

        // var_dump($convert);die;
        return view('admin.bank.transfer.credit')->with('trnsfers', $banktransfer)->with('btc', $btc)
                                                ->with('masterWallets', $masterWallets);
    }



    public function userCredit(){
        $lockings = Lock::all();
        $wallets = Wallet::whereUserId(Auth::id())->get();
        return view('pages.bank.credit')->with('locks', $lockings)->with('wallets', $wallets);
    }


    public function adminBanktransfer(){
        $banktransfer = Banktransfer::paginate(30);
        return view('admin.bank.transfer.index')->with('trnsfers', $banktransfer);
    }

    public function banktransferSearch(){
        $banktransfer = Banktransfer::where('trxid', 'like', '%'.request()->input('search_term').'%')->get();
        return view('admin.search.banktransfer_search')->with('trnsfers', $banktransfer);
    }

    public function approveCredit($userid, $trferId, $coin){
        //check if there is a referrrer, if there is check if he has been rewarded


      return DB::transaction(function() use($userid, $trferId, $coin){
        $user = User::findOrFail($userid);
        $userWallet = Wallet::where('user_id', $user->id)->where('coin_type', 'btc')->first();
        if($user->myref != null){
            $referrer = User::where('mycode', $user->myref)->first();
            $referrerWallet = Wallet::where('user_id', $referrer->id)->where('coin_type', 'btc')->first();

            //check if the referrer have be rewarded
            $btcReward = '';
            $rewarded = Refearning::where('earner', $referrer->id)->where('from', $user->id)->first();
            if(!$rewarded){
                //send coin to this wallet according ref rule.
                $refrule = Refrule::findOrFail(1);
                $creditedAmount = Banktransfer::findOrFail($trferId);
                //if amount is greater than min amount
                if($creditedAmount->amount > $refrule->min_amount){
                    //naira compensation value
                    $cal = new CalculationService();
                    $nairaReward = $cal->actualRefRewardValue($creditedAmount->amount);
                    //convert to btc
                    $btcNairaVal =  Currency::convert()->from('BTC')->to('NGN')->amount(1)
                    ->date(now())->get();
                    $btcReward = $cal->find_x_btc(1, $nairaReward, $btcNairaVal);
                    $transferService = new CoinTransferService();
                    $transferService->transferBtc($btcReward, $referrerWallet, $userWallet, 'btc', );

                }
            }
        }

        $timestamp = '';
        if($creditedAmount->duration == 'ath'){
            $timestamp= null;
        }else{
            $timestamp =  date('Y-m-d H:i:s', strtotime("+".$creditedAmount->duration." months"));
            // strtotime(+$request->duraion." months", $today);
        }
        //reward admin
        $cal = new CalculationService();
        $adminCoinGain = $cal->adminReward($coin);
        $service = new CoinTransferService();
        $adminWallet = SiteSetting::where('cointype', 'btc')->first();
        // new Adminincome()
        $service->transferBtc($adminCoinGain, $adminWallet, $userWallet, 'btc');

        //lock
        $registerLock = new Userlock();
        $registerLock->user_id = $user->id;
        $registerLock->cointype = 'btc';
        $registerLock->address = $userWallet->pass_phrase;
        $registerLock->duration = $creditedAmount->duration;
        $registerLock->amount = $btcReward;
        $registerLock->expry = $timestamp;
        $registerLock->state = 1;
        $registerLock->save();
        // lock the wallet

        $userWallet->state = 1;
        $userWallet->save();
        Session::flash('success', 'Fund locked.');
        return redirect()->back();
      });
    }



    public function activateDebit(){

    }

    public function amountToCreditUserCreditRequest(Banktransfer $transfer, Request $request)
    {
        $request->validate([
            'user_wallet'   =>  'required',
            'master_wallet' =>  'required',
            'amount'        =>  'required',
        ]);

        $userWallet = Wallet::whereId($request->user_wallet)->first();
        $masterWallet = SiteSetting::whereId($request->master_wallet)->first();

        if($userWallet->coin_type != $masterWallet->coin_type)
        {
            session()->flash('failed', "Cannot credit ".strtoupper($userWallet->coin_type)." wallet with ".strtoupper($masterWallet->coin_type)." wallet, Please select appropriate wallet to credit");
            return redirect()->back();
        }

        $transfer->update([
            'master_wallet_id'  =>  $masterWallet->id,
            'user_wallet_id'    =>  $userWallet->id,
            'amount_send'       =>  $request->amount,
        ]);

        session()->flash('success', "Information Saved Successfully, Waiting for Approval");
        return redirect()->back();
    }

    public function approvalUserCreditRequest(Banktransfer $transfer, Request $request)
    {
        //check if there is a referrrer, if there is check if he has been rewarded
        if(is_null($transfer->master_wallet_id) && is_null($transfer->user_wallet_id) && is_null($transfer->amount_send)){
            session()->flash('failed', 'Please Enter amount to send to User');
            return redirect()->back();
        }

        $userid = $transfer->user_id;
        $trferId = $transfer->id;
        $coin = $transfer->amount_send;
        return DB::transaction(function() use($userid, $trferId, $coin, $transfer){
            $user = User::findOrFail($userid);
            $userWallet = Wallet::where('user_id', $user->id)->where('coin_type', $transfer->coin_type)->first();
            $creditedAmount = Banktransfer::findOrFail($trferId);
            $btcReward = '';
            $btcNairaVal =  Currency::convert()->from('BTC')->to('NGN')->amount(1)
            ->date(now())->get();
            if($user->myref != null){
                $referrer = User::where('mycode', $user->myref)->first();
                $referrerWallet = Wallet::where('user_id', $referrer->id)->where('coin_type', $transfer->coin_type)->first();

                //check if the referrer have be rewarded
                $rewarded = Refearning::where('earner', $referrer->id)->where('from', $user->id)->first();
                if(!$rewarded){
                    //send coin to this wallet according ref rule.
                    $refrule = Refrule::findOrFail(1);
                    //if amount is greater than min amount
                    if($creditedAmount->amount > $refrule->min_amount){
                        //naira compensation value
                        $cal = new CalculationService();
                        $nairaReward = $cal->actualRefRewardValue($creditedAmount->amount);
                        //convert to btc
                        $btcReward = $cal->find_x_btc(1, $nairaReward, $btcNairaVal);
                        $transferService = new CoinTransferService();
                        $transferService->transferBtc($btcReward, $referrerWallet, $userWallet, $transfer->coin_type, );

                    }
                }
            }

        $timestamp = '';
        if($creditedAmount->locking_duration == 'ath' && $creditedAmount->locking_duration == null){
            $timestamp= null;
        }else{
            $timestamp =  date('Y-m-d H:i:s', strtotime("+".$creditedAmount->locking_duration." months"));
            // strtotime(+$request->duraion." months", $today);
        }
        $cal = new CalculationService();
        $nairaReward = $cal->actualRefRewardValue($creditedAmount->amount);
        //convert to btc
        $btcReward = $cal->find_x_btc(1, $nairaReward, $btcNairaVal);
        //reward admin
        $cal = new CalculationService();
        $adminCoinGain = $cal->adminReward($coin);
        $service = new CoinTransferService();
        $adminWallet = SiteSetting::where('coin_type', $transfer->coin_type)->first();
        // new Adminincome()
        if($transfer->coin_type == 'btc') {
            $coinTypeApi = env('Bitcoin_Api');
        } elseif ($transfer->coin_type == 'lite') {
            $coinTypeApi = env('Litecoin_Api');
        } elseif ($transfer->coin_type == 'doge') {
            $coinTypeApi = env('Dogecoin_Api');
        } else {
            $coinTypeApi = null;
        }

        $roundAmount = number_format($adminCoinGain, 8, '.', '');

        $status = $service->walletTransaction($roundAmount,$userWallet, $adminWallet, $coinTypeApi);
        if($status) {
            $transfer->update(['approval' => true]);
        }
        //lock
        $registerLock = new Userlock();
        $registerLock->user_id = $user->id;
        $registerLock->cointype = $transfer->coin_type;
        $registerLock->address = $userWallet->pass_phrase;
        $registerLock->duration = $creditedAmount->locking_duration;
        $registerLock->amount = $btcReward;
        $registerLock->expry = $timestamp ?? NULL;
        $registerLock->state = 1;
        $registerLock->save();
        // lock the wallet

        $userWallet->state = 1;
        $userWallet->save();
        Session::flash('success', 'Fund locked.');
        return redirect()->back();
      });
    }

    public function approvalUserDebitRequest(Banktransfer $transfer)
    {
        $cal = new CalculationService();
        $currentBtcVal =  Currency::convert()->from($transfer->coin_type)->to('NGN')->amount(1)->date(now())->get();
        $x_btc = $cal->find_x_btc(1,$transfer->amount, $currentBtcVal);
        $transfer->valinbtc = $x_btc;
        $amount = $transfer->rounded_btc_val = number_format($x_btc, 8, '.', '');
        $userid = $transfer->user_id;
        $trferId = $transfer->id;
        return DB::transaction(function() use($userid, $trferId, $amount, $transfer){
            $user = User::findOrFail($userid);
            $userWallet = Wallet::where('user_id', $user->id)->where('coin_type', $transfer->coin_type)->first();
            $creditedAmount = Banktransfer::findOrFail($trferId);
            $btcReward = '';
            $btcNairaVal =  Currency::convert()->from($transfer->coin_type)->to('NGN')->amount(1)
            ->date(now())->get();
            $service = new CoinTransferService();
            $adminWallet = SiteSetting::where('coin_type', $transfer->coin_type)->first();
            // if($transfer->coin_type == 'btc') {
            //     $coinTypeApi = env('Bitcoin_Api');
            // } elseif ($transfer->coin_type == 'lite') {
            //     $coinTypeApi = env('Litecoin_Api');
            // } elseif ($transfer->coin_type == 'doge') {
            //     $coinTypeApi = env('Dogecoin_Api');
            // } else {
            //     $coinTypeApi = null;
            // }
            $coinType = $transfer->coin_type;
            $adminPercentage = PageSetting::where('key', $transfer->coin_type."_percentage")->first()->value ?? 0;
            $calculateAdminEarning = (new CalculationService)->adminPercentage($adminPercentage, $amount);
            $status = $service->walletTransaction($amount, $adminWallet, $userWallet, $coinType, $calculateAdminEarning);
            if($status) {
                $transfer->update(['approval' => true]);
            }
            return redirect()->back();
      });
    }


}

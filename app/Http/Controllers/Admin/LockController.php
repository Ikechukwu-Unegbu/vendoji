<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\Core\Lock;
use App\Models\V1\Core\Refearning;
use App\Models\V1\Core\Refrule;
use App\Models\V1\Core\Unlock;
use App\Models\V1\Core\Userlock;
use App\Models\V1\transactions\Wallet;
use App\Notifications\InformAdminAboutUnlockRequest;
use App\Notifications\RefPaidNotification;
use App\Services\CoinTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class LockController extends Controller
{
    public function indexAdminPage(){
        $lock = Lock::orderBy('id', 'desc')->get();
        return view('admin.lock.index')->with('locks', $lock);
    }

    public function lockStore(Request $request){
        $request->validate([
            'duration'=>'required|string'
        ]);
        //store
        $lock = new Lock();
        $lock->duration = $request->duration;
        $lock->save();
        Session::flash('success', 'New locking duration created.');
        return redirect()->back();
    }

    public function lockDeactivate($id){
        $lock = Lock::findOrFail($id);
        $lock->state = 0;
        $lock->save();

        Session::flash('success', 'Deactivated');
        return redirect()->back();
    }

    public function lockActivate($id){
        $lock = Lock::findOrFail($id);
        $lock->state = 1;
        $lock->save();

        Session::flash('success', 'Activated');
        return redirect()->back();
    }

    public function lockMyFund(Request $request, $userid){
    //    var_dump($request->all());die;
        $request->validate([
            'wallet'=>'required|string', 
            'duration'=>'required|string'
        ]);

        //calculating timestamp
      return DB::transaction(function() use($request, $userid){
        $today = time();
        $timestamp = '';
        if($request->duration == 'ath'){
            $timestamp= null;
        }else{
            $timestamp =  date('Y-m-d H:i:s', strtotime("+".$request->duration." months"));
            // strtotime(+$request->duraion." months", $today);
        }
        $userlock =  new Userlock();
        $userlock->user_id = $userid;
        $userlock->address = $request->wallet;
        $userlock->duration = $request->duration;
        $userlock->amount = $request->amount;
        $userlock->expry = $timestamp;
        $userlock->cointype = $request->type;
        $userlock->save();

        //mark the wallet as locked
        $userwallet = Wallet::where('pass_phrase', $request->wallet)->first();
        $userwallet->locked_state = 1;
        // $serwallet->duration = $request->duration;
        $userwallet->save();
        //send admin his commission to a master wallet

        //check for referrer
        $user = User::findOrFail($userid);
        if($user->myref != null){
            //check if the referrer has been rewarded
            //find the user that own the code
            $referrer = User::where('mycode', $user->myref)->first();
            $rewarded = Refearning::where('earner', $referrer->id)->where('from', $user->id)->first();
            if(count($rewarded) <1){
              
              //find their wallet that is of same type as the coin being locked
              $referrerWallet = Wallet::where('user_id', $referrer->id)->where('coin_type', $request->type)->first();
              if($referrerWallet){
                  //calculate what percentage to send them
                  $refRule = Refrule::find(1);
                  $actualRefReward = ($refRule->reward/100)*$request->amount;
  
                  //send them crypto
                  $cointranserferService = new CoinTransferService();
                  $cointranserferService->transferBtc($actualRefReward, $referrerWallet, $user->wallets, '');
                  //send notification to referrer
                  Notification::sendNow($referrer, new RefPaidNotification($referrer, $actualRefReward ));
              }
          }

        }
        Session::flash('success', 'Your coin has been successfully locked.');
        return redirect()->back();
      });
    }

    public function cancelMyLock(Request $request, $userid, $walletId){
        return DB::transaction(function() use($request, $userid, $walletId){
            //change state at userlocks table
            $user = User::findOrFail($userid);

            // //change wallet lock state
            // $userlock = Userlock::findOrFail($lockid);
            // $userlock->state = 0;
            // $userlock->save();

            // //find the wallet and unlock it.
            $wallet = Wallet::find($walletId);
            $wallet->locked_state = 2;
            $wallet->save();
            $userlock = Userlock::where('address', $wallet->pass_phrase)->first();
            
            // $wallet->locked_state = 0;
            // $wallet->save();

            $unlock = new Unlock();
            $unlock->wallet_id = $wallet->id;
            $unlock->user_id = $user->id;
            $unlock->reason = $request->unlock_reason;
            $unlock->lock_id = $userlock->id;
            $unlock->save();

            //notify admin
            $admins = User::where('access', 'admin')->orWhere('access', 'superadmin')->get();
            Notification::sendNow($admins, new InformAdminAboutUnlockRequest($unlock));

            Session::flash('success', "Funds unlocked");
            return redirect()->back();
        });


    }
}

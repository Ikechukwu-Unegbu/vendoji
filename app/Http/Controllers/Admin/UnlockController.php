<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use App\Models\User;
use App\Models\V1\Core\Adminincome;
use App\Models\V1\Core\Unlock;
use App\Models\V1\Core\Userlock;
use App\Models\V1\transactions\Wallet;
use App\Notifications\UnlockedAlertForUser;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session as FacadesSession;

class UnlockController extends Controller
{
    public function unlockindex(){
        $unlocks = Unlock::orderBy('id', 'desc')->paginate(30);
        return view('admin.lock.lockcancel')->with('unlocks', $unlocks);
    }

    public function unlockWalletForUser($unlockid){
       return DB::transaction(function() use($unlockid){
        $unlock = Unlock::findOrFail($unlockid);
        $walletOwner = User::find($unlock->user_id);
        $userlock = Userlock::find($unlock->lock_id);
        $wallet = Wallet::find($unlock->wallet_id);
        //set the wallet lock state to zero
        $wallet->locked_state = 0;
        $wallet->save();
        //set the userlock state to zero
        $userlock->state = 0;
        $userlock->save();
        //send the user notification
        Notification::sendNow($walletOwner, new UnlockedAlertForUser($walletOwner, $unlock));
        //take out admin commission

        FacadesSession::flash('success', "Fund unlocked for user");
        return redirect()->back();
       });
    }


    public function adminEarning(){
        return DB::transaction(function(){
            $adminEarning = Adminincome::orderBy('id', 'desc')->paginate(20);
            $allBtc = Adminincome::where('cointype', 'btc')->sum('amount');
            $alldoge = Adminincome::where('cointype', 'doge')->sum('amount');
            $litecoin = Adminincome::where('cointype', 'ltc')->sum('amount');
            return view('admin.lock.admin_earning')->with('earnings', $adminEarning)
                                                    ->with('allbtc', $allBtc)
                                                    ->with('alldoge', $alldoge)
                                                    ->with('all_ltc', $litecoin);
        });

    }

    public function percentageEarning(Request $request)
    {
        $request->validate([
            'wallet_percentage' =>  'required|numeric',
            'wallet'            =>  'required|string',
        ]);

        if($request->wallet !== 'btc' && $request->wallet !== 'lite' && $request->wallet !== 'doge') {
            session()->flash('error', 'Unable to Process Transaction');
            return redirect()->back();
        }

        PageSetting::updateOrCreate(['key' => $request->wallet.'_percentage'], ['value' => $request->wallet_percentage]);
        session()->flash('success', strtoupper($request->wallet)." Percentage Updated Successfully");
        return redirect()->back();
    }


}

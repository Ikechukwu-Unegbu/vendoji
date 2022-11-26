<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\Core\Refrule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReferralController extends Controller
{
    public function adminIndex(){
        $users = User::paginate(20);
        $refrule = Refrule::find(1);
        return view('admin.referrral.referral')->with('users', $users)
                                                ->with('refrule', $refrule);
    }

    public function setRule(Request $request){
        $request->validate([
            'reward'=>'required|string',
            'min_amount'=>'required|string'
        ]);

        //setor
        $refrule =  Refrule::find(1);
        $refrule->reward = $request->reward;
        $refrule->min_amount = $request->min_amount;
        $refrule->save();

        //return
        Session::flash('success', 'Referral rule has been set.');
        return redirect()->back();

    }

    public function changeRef(Request $request, $userid){
        $request->validate([
            'newcode'=>'required|string'
        ]);
        $user = User::findOrFail($userid);
        $user->mycode = $request->newcode;
        $user->save();
        Session::flash('success', 'Code changed.');
        return redirect()->back();
    }

    public function updateRefCode(User $user, Request $request)
    {
        $request->validate(['referral_code' => 'required|unique:users,mycode,'.$user->id]);
        $user->update(['mycode' => $request->referral_code]);
        Session::flash('success', 'Referral code updated Successfully');
        return redirect()->back();
    }
}

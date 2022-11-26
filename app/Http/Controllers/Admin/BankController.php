<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\Bank\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class BankController extends Controller
{

    public function adminIndex(){
        $banks = Bank::all();
        return view('admin.bank.bankindex')->with('banks', $banks);
    }

    public function storeBank(Request $request){
        $request->validate([
            'bank_name'=>'required|string',
            'account_name'=>'required|string',
            'account_number'=>'required|string',
            'phone'=>'required|string'
        ]);
        $bank = new Bank();
        $bank->bank_name = $request->bank_name;
        $bank->account_name = $request->account_name;
        $bank->account_number = $request->account_number;
        $bank->phone = $request->phone;
        $bank->save();

        Session::flash('success', 'Account number set.');
        return redirect()->back();
    }

    public function activateBank($id){
        $bank = Bank::findOrFail($id);
        $allbanks = Bank::all();
        foreach($allbanks as $allbank){
            $allbank->state = 0;
            $allbank->save();
        }
        $bank->state = 1;
        $bank->save();

        Session::flash('success', 'Activated');
        return redirect()->back();
    }

    public function deactivateBank($id){
        $bank = Bank::findOrFail($id);
        // $allbanks = Bank::all();
        // foreach($allbanks as $allbank){
        //     $allbank->state = 0;
        //     $allbank->save();
        // }
        $bank->state = 0;
        $bank->save();

        Session::flash('success', 'Activated');
        return redirect()->back();
    }
}

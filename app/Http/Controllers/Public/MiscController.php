<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\extras\Contact;
use App\Notifications\WeHaveBeenContacted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MiscController extends Controller
{
    public function contactusStore(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|string',
            'message'=>'required|string'
        ]);
        //save
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->body = $request->message;
        $contact->ticket = Str::random(12);
        $contact->save();
        //notify admin
        $admins = User::where('access', 'admin')->get();
        Notification::sendNow($admins, new WeHaveBeenContacted($contact));
        //send a message
        Session::flash('success', 'Your message has been recieved. We will be in touch.');
        return redirect()->back();
    }

    public function about(){
        return ;
    }
}

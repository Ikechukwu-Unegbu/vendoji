<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\Newsletter\Newsletter;
use App\Notifications\NewsletterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make( request()->all(), ['email' => 'required|email|max:30|unique:newsletters,email'], [
            'email.required' => 'Please enter your email',
            'email.email'   =>  'Please enter a valid a Email',
            'email.unique'  =>  'This email is already exist'
        ]);

        if($validator->fails()){
            // return redirect()->to(url('#newsletter'));
            session()->flash('newslettererror', $validator->errors()->first());
            return redirect()->to(url()->previous()."#newsletter");
        }

        try {

            Newsletter::create([
                'email' =>  $request->email
            ]);

            $admins = User::whereAccess('admin')->get();
            session()->flash('newslettersuccess', 'You have successfully subscribed to our newsletter');
            Notification::sendNow($admins, new NewsletterNotification("{$request->newsletter} subscribed to your Newsletter"));

        } catch (\Exception $e) {
            // session()->flash('newslettererror', "This email could not be added to our newsletter list.");
            // ValidationException::withMessages([
            //     'newsletter' =>  'This email could not be added to our newsletter list.'
            // ]);
        }

        // return redirect()->to(url('#newsletter'));
        return redirect()->to(url()->previous()."#newsletter");
    }

    public function index()
    {

        return view('admin.newletter.index', ['newsletters' => Newsletter::orderBy('created_at', 'DESC')->paginate(20), 'subscribed' => Newsletter::count()]);
    }
}

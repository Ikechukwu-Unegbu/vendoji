<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\V1\transactions\Wallet;
use App\Notifications\email\Welcome;
use App\Notifications\NewUserNotifyAdmin;
use App\Notifications\WelcomeEmail;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Stringable;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
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


    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        // var_dump($request->all());die;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mycode'=>rand(1000, 100000).''.Str::random(4)
        ]);

        //Create BTC Wallet
        $apiKey = env('Bitcoin_Api');
        $label = $user->email;
        try {
            $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_new_address/?api_key={$apiKey}&label={$label}")->getBody(), true);
            if($wallet['status'] == 'success'){
                $address = $wallet['data']['address'];
                $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
                $availableBalance = $balance['data']['available_balance'];
                Wallet::create([
                    'user_id' => $user->id,
                    'password' => null,
                    'pass_phrase' => $address,
                    'balance' => $availableBalance,
                    'password'  =>  Hash::make($request->password),
                    'coin_type' => 'btc'
                ]);
                activity()->log('wallet created successfully')->causer($user->id);
                session()->flash('success', 'Bitcoin Wallet Created Successfully');
            } elseif($wallet['status'] === 'fail') {
                activity()->log('error while creating wallet')->causer($user->id);
                session()->flash('error', $wallet['data']['error_message']);
            }
        } catch (\Exception $e) {
            activity()->log($e->getMessage())->causer($user->id);
            session()->flash('error', 'Unable to create wallet, Check your connection');
        }


        try {
            $admins = User::where('access', 'admin')->get();
            Notification::sendNow($admins, new NewUserNotifyAdmin($user));
            // send user email
            Notification::sendNow($user, new Welcome($user));
            //handle ref
            if($request->ref != null){
                $newuser = User::where('email', $request->email)->first();
                $newuser->referral = $request->ref;
                $newuser->save();
            }
            //send notification to admin
        } catch (\Exception $e) {
            session()->flash('error', 'Connection could not be established');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

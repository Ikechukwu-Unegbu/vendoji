<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\OTP;
use App\Models\V1\Core\Lock;
use App\Models\V1\extras\Faq;
use App\Models\V1\extras\Faqcategory;
use App\Models\V1\transactions\Transaction;
use Illuminate\Http\Request;
use App\Models\V1\transactions\Wallet;
use GuzzleHttp\Client;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\User;

use App\Models\UserLocation;

// use Illuminate\Support\Facades\Auth;

use Spatie\Activitylog\Models\Activity;
use Stevebauman\Location\Facades\Location as FacadesLocation;
use Illuminate\Support\Facades\Auth;
class PagesController extends Controller
{

    public function flutterApiClient($method, $apiLink)
    {
        $apiKey = env('SECRET_KEY');
        $client = new Client();
        $request = $client->request($method, $apiLink, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$apiKey}"
            ],
            'verify' => false,
            'http_errors' => false
        ]);
        return $request;
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

    public function index()
    {
        $faqs_number = count(Faq::all());
        $faq_rounded = floor($faqs_number/2);

        $first_half = Faq::skip(0)->take($faq_rounded)->get(); //get first 10 rows
        $second_half = Faq::skip($faq_rounded)->take($faq_rounded)->get(); //get first 10 rows

        // $faqs = Faqcategory::all();
        return view('pages.home.index')->with('faq_first', $first_half)->with('faq_second', $second_half);
    }


    public function faq(){
        $faqs = Faqcategory::all();
        return view('pages.faq.index')->with('faqcates', $faqs);
    }

    public function dashboard()
    {

        $location = FacadesLocation::get(request()->ip());
        if($location != false) {
            UserLocation::updateOrCreate(['user_id' =>  Auth::id()],
            [
                'ip'    =>   $location->ip,
                'country_name'  =>   $location->countryName,
                'country_code'  =>   $location->countryCode,
                'regional_name' =>   $location->regionCode,
                'city_name' =>   $location->cityName,
                'zip_code'  =>   $location->zipCode ?? null,
                'latitude'  =>   $location->latitude,
                'longitude'  =>   $location->longitude
            ]);
        }

        $user = auth()->user();
        $wallets = Wallet::whereUserId($user->id)->get();
        // $apiKey = env('Bitcoin_Api');
        // try{
        //     $address = $wallets->where('coin_type', 'btc')->first()->pass_phrase ?? '';
        //     $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
        //     $availableBalance = $balance['data']['available_balance'];
        //     Wallet::whereUserId($user->id)->whereCoinType('btc')->first()->update(['balance' => $availableBalance ?? 0.00]);
        // }catch (\Exception $e){
        //     // session()->flash('failed', 'Error while fetching wallet balance');
        // }
        $ref = User::find(Auth::user()->id)->mycode;
        //fetch locks
        $locks = Lock::all();
        $activities = Activity::whereCauserId(auth()->user()->id)->latest()->take(5)->get();
        return view('pages.userdashboard.index', compact('activities', 'wallets', 'locks'))
            ->with('refcode', $ref);
    }

    public function contactus()
    {
        return view('pages.contactus.index');
    }
    public function walletIndex()
    {
        $user = auth()->user();
        $wallets = Wallet::whereUserId($user->id)->get();
        try{
            foreach($wallets as $wallet) {
                if($wallet->coin_type == 'btc'){
                    $apiKey = env('Bitcoin_Api');
                } elseif($wallet->coin_type == 'lite') {
                    $apiKey = env('Litecoin_Api');
                } elseif ($wallet->coin_type == 'doge') {
                    $apiKey = env('Dogecoin_Api');
                }
                $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$wallet->pass_phrase}")->getBody(), true);
                $availableBalance = $balance['data']['available_balance'];
                $wallet->update(['balance' => $availableBalance ?? 0.00]);
            }
        }catch (\Exception $e){
            session()->flash('failed', 'Error while fetching wallet balance');
            // session()->flash('failed', $e->getMessage());

        }
        return view('pages.wall.index', compact('wallets'));
    }

    public function withdrawalIndex()
    {
        $banks = json_decode($this->flutterApiClient('GET', "https://api.flutterwave.com/v3/banks/NG")->getBody(), true);
        return view('pages.withdrawal.index', compact('banks'));
    }

    public function otpIndex(OTP $otp, $transaction)
    {
        $trx = Transaction::findOrFail($transaction);
        return view('pages.withdrawal.verify', compact('otp', 'trx'));
    }

    public function BitCoin()
    {
        $convert = [];
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
            if (date('m', $time)==date('m')){
                if(date('Y-m-d', $time) <= date('Y-m-d')){
                    $convert['date'][] = date('d M', $time);
                    $convert['rate'][] = Currency::convert()
                        ->from('BTC')
                        ->to('NGN')
                        ->amount(1)
                        ->date(date('Y-m-d', $time))
                        ->get();
                }
            }
        }

        $label = $convert['date'];
        $data = array_filter($convert['rate']);
        return response()->json(compact('label', 'data'));
    }

    public function USDCoin()
    {
        $convert = [];
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
            if (date('m', $time)==date('m')){
                if(date('Y-m-d', $time) <= date('Y-m-d')){
                    $convert['date'][] = date('d M', $time);
                    $convert['rate'][] = Currency::convert()
                        ->from('USD')
                        ->to('NGN')
                        ->amount(1)
                        ->date(date('Y-m-d', $time))
                        ->get();
                }
            }
        }

        $label = $convert['date'];
        $data = $convert['rate'];
        return response()->json(compact('label', 'data'));
    }
}

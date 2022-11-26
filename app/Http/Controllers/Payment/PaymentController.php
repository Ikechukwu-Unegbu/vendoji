<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OTP;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\V1\transactions\Transaction;
use App\Models\V1\transactions\Wallet;
use App\Notifications\AccountFundingNotification;
use App\Notifications\ContributionNotification;
use Flutterwave\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
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

    public function flutterApiClient($method, $apiLink)
    {
        $apiKey = env('FLUTTER_API_KEY');
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


    public function initiate(Request $request)
    {
        $this->validate($request, [
            'amount'    =>  'required|integer',
        ]);
        $request = [
            'tx_ref' => time(),
            'amount' => $request->amount,
            'currency' => 'NGN',
            'payment_options' => 'card',
            'redirect_url' => url('dashboard/funding'),
            'customer' => [
                'email' => auth()->user()->email,
                'name' => auth()->user()->name
            ],
            'meta' => [
                'price' => 1000,
            ],
            'customizations' => [
                'title' => 'Account Funding',
                'description' => 'Account Funding'
            ]
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($request),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.env('SECRET_KEY'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);

        if(isset($res->status) && $res->status == 'success')
        {
            $link = $res->data->link;
            return redirect()->to($link);
        }
        else
        {
            session()->flash('failed', 'We can not process your payment');
            return redirect()->to(url('dashboard/funding'));
        }
    }

    public function fundingIndex()
    {

        $transactions = Transaction::whereUserId(auth()->user()->id)->where('trx_type', 'contribution')->orderBy('created_at', 'DESC')->get();

        if (is_null(request()->status))
        {
            return view('pages.funding.index', compact('transactions'));
        }
        elseif (request()->status == 'successful')
        {
            $transactionId = request()->transaction_id;
            $response = json_decode($this->flutterApiClient('GET', "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify")->getBody(), true);

            if($response['status'] === 'success')
            {
                DB::transaction(function() use ($response, $transactionId)
                {
                    try{
                        Transaction::create(
                        [
                            'user_id'  =>  auth()->user()->id,
                            'amount'    =>  $response['data']['amount'],
                            'trx_id'    =>  $transactionId,
                            'trx_ref'   =>  $response['data']['tx_ref'],
                            'payment_type'  =>  $response['data']['payment_type'],
                            'status'    =>  true,
                            'trx_type'    =>  'contribution'
                        ]);
                        $totalBalance = Transaction::whereUserId(auth()->user()->id)->where('trx_type', 'contribution')->sum('amount');
                        auth()->user()->notify(new AccountFundingNotification(auth()->user(), $response['data']['amount'], $totalBalance));
                        activity()->log('payment successful')->causer(auth()->user()->id);
                        session()->flash('success', 'Payment Successful');


                    } catch (\Exception $ex) {
                        DB::rollback();
                        activity()->log('payment failed')->causer(auth()->user()->id);
                        session()->flash('success', 'Payment Failed');

                    }
                });

                return redirect()->route('funding.index');
            }
            elseif($response['status'] === 'cancelled')
            {
                // dd($response);
                // Transaction::create(
                // [
                //     'user_id'  =>  auth()->user()->id,
                //     'amount'    =>  $response['data']['amount'],
                //     'trx_id'    =>  $transactionId,
                //     'trx_ref'   =>  $response['data']['tx_ref'],
                //     'payment_type'  =>  $response['data']['payment_type'],
                //     'status'    =>  false,
                //     'trx_type'    =>  'contribution'
                // ]);
                activity()->log('payment cancelled')->causer(auth()->user()->id);
                session()->flash('success', 'Payment Cancelled');
                return redirect()->route('funding.index');
            }else{
                return redirect()->route('funding.index');
            }
        }else {
            activity()->log('payment cancelled')->causer(auth()->user()->id);
            session()->flash('success', 'Payment Cancelled');
            return view('pages.funding.index', compact('transactions'));
        }
    }





    public function withdrawalInitialize()
    {
        $this->validate(request(), [
            'account'    =>  'required',
            'amount'    =>  'required',
            'bank'    =>  'required',
        ]);

        $customerDetails = [
            'length'    =>  6,
            'customer' => [
                    'name'  =>  auth()->user()->name,
                    'email' =>  auth()->user()->email,
                    'phone' =>  auth()->user()->phone
            ],
            'sender'    => env('APP_NAME'),
            'send'  => true,
            'medium'    => ['email', 'whatsapp'],
            'expiry'    => 5
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flutterwave.com/v3/otps',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($customerDetails),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.env('SECRET_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);

        if(isset($res->status) && $res->status == 'success'){
            $otp = OTP::create([
                'user_id'   =>  auth()->user()->id,
                'otp'   =>  $res->data[0]->otp,
                'reference' =>  $res->data[0]->reference,
                'expiry'    =>  $res->data[0]->expiry,
                'slug'      =>  Str::random(10)
            ]);


            $trx = Transaction::create([
                'user_id'  =>  auth()->user()->id,
                'amount'    =>  request()->amount,
                'account_number'    =>  request()->account,
                'bank_id'   =>  request()->bank,
                'trx_id'    =>  null,
                'trx_ref'   =>  $res->data[0]->reference,
                'payment_type'  =>  'account_number',
                'status'    =>  false,
                'trx_type'    =>  'withdraw'
            ]);

            return redirect()->to(route('otp.index', [$otp->slug, $trx->id]));
        }else {
            session()->flash('failed', 'Withdraw Failed');
            return redirect()->to(route('withdrawal.index'));
        }

    }

    public function otpVerify(OTP $otp, $transaction)
    {
        $trx = Transaction::findOrFail($transaction);

        $this->validate(request(), [
            'otp'   =>  'required',
        ]);
        if($otp->user_id !== auth()->user()->id){
            session()->flash('failed', 'Username not Match');
            return redirect()->to(route('otp.verified', [$otp->slug, $trx->id]));
        }elseif($otp->otp !== request()->otp){
            session()->flash('failed', 'Invalid OTP!');
            return redirect()->to(route('otp.verified', [$otp->slug, $trx->id]));
        }else{
            $curl = curl_init();

            $verifiedOtp = ['otp' => request()->otp];

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/otps/{$otp->reference}/validate",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($verifiedOtp),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.env('SECRET_KEY'),
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($response);
            if(isset($res->status) && $res->status == 'success'){
                $Accdetails = [
                    'account_bank'  =>   $trx->bank_id,
                    'account_number'    =>   $trx->account_number,
                    'amount'    =>   $trx->amount,
                    'narration' =>   'Withdrawal',
                    'currency'  =>   'NGN',
                    'reference' =>   Str::slug(auth()->user()->name).'-rf'.time(),
                ];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.flutterwave.com/v3/transfers",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($Accdetails),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer '.env('SECRET_KEY'),
                        'Content-Type: application/json'
                    ),
                ));

                $WithDrawresponse = curl_exec($curl);
                curl_close($curl);

                $WithDrawal = json_decode($WithDrawresponse);
                dd($WithDrawal);
                activity()->log('withdrawal successful')->causer(auth()->user()->id);
                $otp->update(['status' => true]);
                $trx->update(['status' => true]);
                session()->flash('success', $WithDrawal->message);

                return redirect()->to(route('withdrawal.index'));
            }else {
                activity()->log('withdrawal cancelled')->causer(auth()->user()->id);
                session()->flash('failed', 'Withdraw Failed!');
                return redirect()->to(route('withdrawal.index'));

            }
        }
    }


}

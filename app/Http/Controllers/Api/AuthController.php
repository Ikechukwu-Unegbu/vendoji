<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\V1\transactions\Wallet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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

    public function register(Request $request)
    {
        if ($request->wantsJson())
        {
            $validator = Validator::make($request->all(), [
                'name'  =>  'required|string',
                'email'     =>  'required|email|unique:users,email',
                'password'  =>  'required|string|min:8',
                'password_confirmation'  =>  'required|same:password',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name'  =>  $request->name,
                'email'     =>  $request->email,
                'password'  =>  bcrypt($request->password),
                'access'    =>  'user',
            ]);

            $token = $user->createToken('API TOKEN')->plainTextToken;
            //Create BTC Wallet
            $apiKey = env('Bitcoin_Api');
            $label = $user->email;
            try {
                $wallet = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_new_address/?api_key={$apiKey}&label={$label}")->getBody(), true);
                if($wallet['status'] === 'success'){
                    $address = $wallet['data']['address'];
                    $balance = json_decode($this->bitcoinApiClient('GET', "https://block.io/api/v2/get_address_balance/?api_key={$apiKey}&addresses={$address}")->getBody(), true);
                    $availableBalance = $balance['data']['available_balance'];
                    $newWallet = Wallet::create([
                        'user_id' => $user->id,
                        'password' => null,
                        'pass_phrase' => $address,
                        'balance' => $availableBalance,
                        'password'  =>  Hash::make($request->password),
                        'coin_type' => 'btc'
                    ]);
                    activity()->log('wallet created successfully')->causer($user->id);
                } elseif($wallet['status'] === 'fail') {
                    activity()->log('error while creating wallet')->causer($user->id);
                }
            } catch (\Exception $e) {
                activity()->log('error while creating wallet')->causer($user->id);
            }

            return response()->json([
                'status' => 'true',
                'message' => 'User Created Successfully',
                'token' => $token,
                'data' => $user,
                'wallet' => $newWallet
            ]);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function login(Request $request)
    {
        if ($request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'email'     =>  'required|email',
                'password'  =>  'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized!, check your login credentials',
                    'data'  =>  []
                ], 422);
            }

            $user = $request->user();

            if ($user->access == 'user') {
                $token = $user->createToken('API TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'data'  => $user,
                    'token' =>  $token
                ], 200);
            }

            return response()->json([
                'status'    =>  false,
                'message'   =>  "You are not authorized to access the page!",
                'data'      =>  []
            ]);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function AdminRegister(Request $request)
    {
        if ($request->wantsJson())
        {
            $validator = Validator::make($request->all(), [
                'name'  =>  'required|string',
                'email'     =>  'required|email|unique:users,email',
                'password'  =>  'required|string|min:6',
                'password_confirmation'  =>  'required|same:password',
                'profile_image' =>  'nullable|image|max:2048'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (request()->profile_image && request()->profile_image->isValid()) {
                $fileName = time().'.'.request()->profile_image->extension();
                request()->profile_image->move(public_path('profile'), $fileName);
                $path = "profile/$fileName";
            }

            $user = User::create([
                'name'  =>  $request->name,
                'email'     =>  $request->email,
                'password'  =>  bcrypt($request->password),
                'access'    =>  'admin',
                'image'     =>  $path ?? '',
            ]);

            $token = $user->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'message' => 'Admin Created Successfully',
                'user'  =>  $user,
                'token' => $token
            ]);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function AdminLogin(Request $request)
    {
        if ($request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'email'     =>  'required|email',
                'password'  =>  'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized!, check your login credentials',
                ], 422);
            }

            $user = $request->user();

            if ($user->access == 'admin') {
                $token = $user->createToken('API TOKEN')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'username'  =>  $user->name,
                    'access'  =>  $user->access,
                    'token' => $token,
                ], 200);
            }

            return response()->json([
                'message'   =>  "You are not authorized to access the page!"
            ]);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function logout()
    {
        if (request()->wantsJson())
        {
            request()->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message'   =>  "User Logged out Successfully",
            ]);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }
}

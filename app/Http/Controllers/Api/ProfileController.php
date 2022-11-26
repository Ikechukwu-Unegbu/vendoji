<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        if (request()->wantsJson()) {
            try {
                $user = User::with('kin')->whereId(auth()->user()->id)->first() ?? '';
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'User Profile',
                    'data'  =>  $user,
                ]);
            } catch(Exception $e) {
                return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => [] ], 500);
            }
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function EditProfile()
    {
        if (request()->wantsJson()) {
            try {
                $profile = User::findOrFail(auth()->user()->id);
                $validator = Validator::make(request()->all(), [
                    "name"  =>  'required',
                    "email" =>  'required|email|unique:users,email,'.$profile->id,
                    "phone" =>  'nullable',
                    "gender"    =>  'nullable',
                    "state" =>  'nullable',
                    "town"  =>  'nullable',
                    'profile_image' =>  'nullable|image|max:2048',
                ]);

                if($validator->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                else {

                    if (request()->profile_image && request()->profile_image->isValid()) {
                        if(File::exists(public_path()."/{$profile->image}")){
                            File::delete(public_path()."/{$profile->image}");
                        }
                        $fileName = time().'.'.request()->profile_image->extension();
                        request()->profile_image->move(public_path('profile'), $fileName);
                        $path = "profile/$fileName";
                    }
                    $profile->update([
                        "name"  =>  request()->name,
                        "email"     =>  request()->email,
                        "phone"     =>  request()->phone,
                        "gender"    =>  request()->gender,
                        "state"     =>  request()->state,
                        "town"      =>  request()->town,
                        "image"     =>  $path ?? $profile->image
                    ]);

                    return response()->json(['status' => 'true', 'message' => 'Profile Upadate Successfully', 'data' => $profile]);
                }
            } catch (Exception $e) {
                return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => [] ], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function getUsers()
    {
        if (request()->wantsJson() && auth()->user()->access == 'admin') {
            $users = User::whereAccess('user')->orderBy('created_at', 'DESC')->get();
            return response()->json($users);
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function getUserProfile($user)
    {
        if (request()->wantsJson() && auth()->user()->access == 'admin') {

            try {
                $user = User::findOrfail($user);
                return response()->json(['status' => 'true', 'message' => 'User Profile', 'data' => $user]);
            } catch (Exception $e) {
                return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => [] ], 500);
            }
        }
        else
        {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function updateUserProfile($user)
    {
        if (request()->wantsJson() && auth()->user()->access == 'admin') {
            try {
                $profile = User::findOrfail($user);
                $validator = Validator::make(request()->all(), [
                    "name"  =>  'required',
                    "email" =>  'required|email|unique:users,email,'.$profile->id,
                    "phone" =>  'nullable',
                    "gender"    =>  'nullable',
                    "state" =>  'nullable',
                    "town"  =>  'nullable',
                    'profile_image' =>  'nullable|image|max:2048',
                ]);

                if ($validator->fails()) {
                    $error = $validator->errors()->all()[0];
                    return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
                } else {
                    if (request()->profile_image && request()->profile_image->isValid()) {
                        $fileName = time().'.'.request()->profile_image->extension();
                        request()->profile_image->move(public_path('profile'), $fileName);
                        $path = "profile/$fileName";
                    }
                    $profile->update([
                        "name"  =>  request()->name,
                        "email"     =>  request()->email,
                        "phone"     =>  request()->phone,
                        "gender"    =>  request()->gender,
                        "state"     =>  request()->state,
                        "town"      =>  request()->town,
                        "image"     =>  $path ?? null
                    ]);

                    return response()->json(['status' => 'true', 'message' => 'Profile Upadate Successfully', 'data' => $profile]);
                }
            } catch (Exception $e) {
                return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => [] ], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }

    public function destroyUser($user)
    {
        if (request()->wantsJson() && auth()->user()->access == 'admin') {
            try {
                $deleteUser = User::findOrFail($user);
                if(!empty($deleteUser->image)){
                    // Storage::disk('public')->delete($deleteUser->image);
                    File::delete(public_path()."/{$deleteUser->image}");
                }
                $deleteUser->delete();
                return response()->json(['status' => 'true', 'message' => 'Profile Deleted Successfully', 'data' => [] ]);
            } catch(Exception $e) {
                return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => [] ], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' =>  'Undefined API Request', 'data' => [] ], 500);
        }
    }
}

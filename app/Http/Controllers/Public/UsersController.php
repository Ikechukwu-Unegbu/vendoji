<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ContributionNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\directoryExists;

class UsersController extends Controller
{
    public function show($id){
        $user = User::findOrFail($id);
        return view('admin.users.show')->with('user', $user);
    }

    public function destroyUser($userId){
        $user = User::findOrFail($userId);
        $user->delete();
        FacadesSession::flash('success', 'User destroyed.');
        return redirect()->back();
    }

    public function userSetting($username){

    }

    public function userProfile($userId)
    {
        $user = User::findOrFail($userId);

        return view('pages.userdashboard.profile')->with('user', $user);
    }

    public function userProfileImage(User $user)
    {
        if (request()->ajax()) {
            try {
                if (!is_null($user->image) && File::exists(public_path()."/{$user->image}")){
                    File::delete(public_path()."/{$user->image}");
                    $user->update(['image' => null]);
                    session()->flash('success', 'Profile Image Deleted Successfully');
                    return response()->json(['status' => true]);
                } else {
                    session()->flash('error', 'Profile Image Not Found!');
                    return response()->json(['status' => false]);
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Profile Image Not Found!');
                return response()->json(['status' => false]);
            }
        }
    }


    public function userProfilePassword(User $user)
    {
        request()->validate([
            'password'  =>  'required|string',
            'newpassword'   =>  'required|string|min:8',
            'renewpassword' =>  'same:newpassword'
        ]);

        $checkPreviousPassword = Hash::check(request()->password, $user->password);
        if ($checkPreviousPassword) {
            $user->update(['password' => bcrypt(request()->newpassword)]);
            session()->flash('success', 'Password Reset Successfully');
            return redirect()->back();
        } else {
            session()->flash('error', 'The Current Password does not match our Records!');
            return redirect()->back();
        }
    }

    public function userProfileUpdate(User $user)
    {
        request()->validate([
            'full_name'  =>  'required|string',
            'email' =>  'required|email|unique:users,email,'.$user->id,
            'phone' =>  'required',
            'address'   =>  'required|string',
            'country'   =>  'required|string',
            'state'     =>  'required|string',
            'gender'    =>  'required|string',
            'profile_image' =>  'nullable|image|max:2048'
        ]);

        if(!empty(request()->profile_image))
        {
            if (!is_null($user->image) && File::exists(public_path()."/{$user->image}")){
                File::delete(public_path()."/{$user->image}");
                $fileName = time().'.'.request()->profile_image->extension();
                request()->profile_image->move(public_path('profile'), $fileName);
                $path = "profile/$fileName";
            } else {
                $fileName = time().'.'.request()->profile_image->extension();
                request()->profile_image->move(public_path('profile'), $fileName);
                $path = "profile/$fileName";
            }
        }else{
            $path = null;
        }

        $user->update([
            'name'      =>      request()->full_name,
            'email'     =>      request()->email,
            'phone'     =>      request()->phone,
            'town'      =>      request()->address,
            'country'   =>      request()->country,
            'state'     =>      request()->state,
            'gender'    =>      request()->gender,
            'image'     =>      $path,
        ]);

        session()->flash('success', 'Profile updated Successfully');
        return redirect()->back();
    }


}

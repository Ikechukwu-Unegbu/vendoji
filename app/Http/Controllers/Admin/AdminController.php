<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLocation;
use App\Models\V1\Core\Userlock;
use App\Models\V1\transactions\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\LinesOfCode\Counter;
use Spatie\Activitylog\Models\Activity;
use Stevebauman\Location\Facades\Location as FacadesLocation;

class AdminController extends Controller
{
    public function index()
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

        $months = [];
        $monthName = [];
        for ($m=1; $m<=12; $m++) {
            $months[] = date('m', mktime(0,0,0,$m, 1, date('Y')));
            $monthName[] = date('M', mktime(0,0,0,$m, 1, date('Y')));

        }

        $MonthlyRegisteredUsers = [];
        foreach ($months as $month) {
            $MonthlyRegisteredUsers[] = User::where('access', 'user')->whereRaw('MONTH(created_at) = ?', $month)->count();
        }
        $activities = Activity::whereCauserId(auth()->user()->id)->latest()->take(5)->get();
        $totalUsers = count(User::all());
        $allWallets = Wallet::all()->sum('balance');
        $allLocks = count(Userlock::all());
        $uniqueLocks = Userlock::distinct()->count('user_id');
        return view('admin.home.index', [
            'months'    =>  $monthName,
            'monthlyRegisteredUsers'  =>  $MonthlyRegisteredUsers,
            'activities'    =>  $activities, 
            'users'=>$totalUsers,
            'totalInWallet'=>$allWallets,
            'all_locks'=>$allLocks,
            'unique_locks'=>$uniqueLocks
        ]);
    }


    public function usersIndex(){
        $users = User::paginate(10);
        return view('admin.users.index')->with('users', $users);
    }

    // public function adminManagementIndex(){
        
    //     return view('admin.admin.admin');
    public function management()
    {
        $admins = User::where('access', 'admin')->orWhere('access', 'superadmin')->paginate(20);
        return view('admin.management.index', ['admins' => $admins]);
    }

    public function appointUser(Request $request, User $user)
    {
        if($user->access == 'superadmin') {
            session()->flash('error', 'User has already been assigned as Superadmin');
            return redirect()->back();
        } else {
            $user->update(['access' => 'superadmin']);
            session()->flash('success', 'User Assigned Successfully');
            return redirect()->back();
        }
    }

    public function revokeUser(Request $request, User $user)
    {
        if($user->access == 'superadmin') {
            session()->flash('error', 'Error! Unable to Revoke User');
            return redirect()->back();
        } else {
            $user->update(['access' => 'user']);
            session()->flash('success', 'User Revoked Successfully');
            return redirect()->back();
        }
    }

    public function userLocations()
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $locations = UserLocation::whereBetween('created_at', [$start_date, $end_date])->paginate(20);
        } else {
            $locations = UserLocation::latest()->paginate(20);
        }
        return view('admin.location.index', ['locations' =>  $locations]);
    }

}

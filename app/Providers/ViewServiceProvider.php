<?php

namespace App\Providers;

use App\Models\PageSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */

    public function boot()
    {

        View::composer('*', function($view){
            if(Auth::check()){
                $user = User::find(Auth::user()->id);
                $notifications = User::find(Auth::user()->id)->notifications()->paginate(20);//auth()->user()->notifications->paginate(20);
                $unread = User::find(Auth::user()->id)->unreadNotifications;
                // $packages = Package::all();
                // $contacts = Contact::where('resolved', 0)->get();
                $view->with('notifications', $notifications)
                                        ->with('unread', $unread)
                                        ->with('loggedUser', $user);
                                        // ->with('packages',$packages)
                                        // ->with('contactus', $contacts);
            }
            $view->with('settings', PageSetting::all()->pluck('value', 'key')->toArray());

        });
    }
}

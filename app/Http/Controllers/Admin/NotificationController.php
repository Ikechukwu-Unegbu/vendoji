<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notification.index');
    }

    public function markNotification(Request $request)
    {
        auth()->user()->unreadNotifications->when($request->id, function ($query) use($request) {
            return $query->where('id', $request->id);
        })->markAsRead();
        return response()->json(['status' => true]);
    }

    public function destroyNotification(Request $request)
    {
        auth()->user()->notifications->where('id', $request->id)->first()->delete();
        session()->flash('success', 'Notification Deleted Successfully');
        return response()->json(['status' => true]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageSetting;
use Illuminate\Support\Facades\File;
class HomeSettingsController extends Controller
{
    public function index()
    {
        return view('admin.homesettings.index', ['settings' => PageSetting::pluck('value', 'key')->toArray()]);
    }

    public function contactUpdate(Request $request)
    {
        $request->validate([
            'contact_address'   =>  'required',
            'phone_number'   =>  'required',
            'contact_email'   =>  'required',
            'open_hour'   =>  'required',
        ]);

        PageSetting::updateOrCreate(['key' => 'contact_address'], ['value' => $request->contact_address]);
        PageSetting::updateOrCreate(['key' => 'contact_mobile'], ['value' => $request->phone_number]);
        PageSetting::updateOrCreate(['key' => 'contact_email'], ['value' => $request->contact_email]);
        PageSetting::updateOrCreate(['key' => 'contact_open_hour'], ['value' => $request->open_hour]);

        session()->flash('success', 'Settings Updated Successfully');
        return redirect()->back();
    }

    public function logoUpdate()
    {
        request()->validate(['logo' =>  'required|image|max:2048']);
        $fileName = 'logo.png';
        request()->logo->move(public_path('site-logo'), $fileName);
        $path = "site-logo/$fileName";
        PageSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        session()->flash('success', 'Logo Updated Successfully');
        return redirect()->back();
    }

    public function logoDestroy()
    {
        if (request()->ajax()) {
            try {
                if (File::exists(public_path()."/site-logo/logo.png")) {
                    File::delete(public_path()."/site-logo/logo.png");
                    PageSetting::updateOrCreate(['key' => 'site_logo'], ['value' => "site-logo/default-logo.png"]);
                    session()->flash('success', 'Logo Deleted Successfully');
                    return response()->json(['status' => true]);
                } else {
                    session()->flash('error', 'Logo Not Found!');
                    return response()->json(['status' => false]);
                }
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
                return response()->json(['status' => false]);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function admin(){
        if(request()->input('category') == null || request()->input('term') == null){
            return view('admin\search\users_result');
        }elseif(request()->input('category') == 'users'){
            $users = User::where('name', 'like', '%'.request()->input('term').'%')->get();
            return view('admin\search\users_result')->with('result', $users);
        }
    }
}

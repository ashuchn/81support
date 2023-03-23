<?php

namespace App\Http\Controllers\subadmin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Validator;
use Session;
use Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('subadmin.profile.index' , $params);
    }

    public function update(Request $request)
    {
        return redirect()->route('subadmin.profile.index');
    }
}

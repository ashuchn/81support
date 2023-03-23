<?php

namespace App\Http\Controllers\subadmin;
use App\Http\Controllers\Controller;
use App\Models\Riding_Charter_User;
use Validator;
use Session;
use Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $subadmin_id = Session::get('subadminId');
        $subadmin = Riding_Charter_User::where('id', $subadmin_id)->first();
        $params = [
            'subadmin_id' => $subadmin_id,
            'subadmin_email' => $subadmin->email,
            'subadmin_pass' => $subadmin->password
        ];
        return view('admin.profile.index' , $params);
    }

    public function update(Request $request)
    {
        return redirect()->route('subadmin.profile.index');
    }
}

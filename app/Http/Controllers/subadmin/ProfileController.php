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
            'subadmin' => $subadmin
        ];
        return view('subadmin.profile.index' , $params);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ], [
            'required' => ':attribute is required',
            'same' => ':attribute does not match'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $admin_id = Session::get('adminId');
        $admin = Admin::where('id', $admin_id)->first();

        if( !Hash::check($request->password , $admin->password)) {
            return back()->with('err_msg','Invalid Password');
        } else {
            $admin->password = Hash::make($request->confirm_password);
            $admin->save();
            return back()->with('success_msg','Password updated successfully');
        }
        
        return redirect()->route('admin.profile.index');
    }
}

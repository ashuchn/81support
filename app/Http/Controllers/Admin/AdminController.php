<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Session;
use Validator;
use Hash;
use DB;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|exists:admin',
            'password' =>'required'
        ], [
            'required' =>':attribute is required',
            'email.exists' =>':attribute does not exist',
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $checkEmail = DB::table('admin')->where(['email'=>$request->email])->first();
        if( !$checkEmail || !Hash::check($request->password , $checkEmail->password)) {
            return back()->with('err_msg', 'Invalid Email or Password');
        } else {
            session()->put('adminId', $checkEmail->id);
            return redirect()->route('admin.dashboard');
        }
    } 


    public function dashboard()
    {
        $users = DB::table('new_users')->count();
        $ridingCharters = DB::table('riding_charter_users')->count();
        $products = DB::table('products')->count();
        $categories = DB::table('categories')->count();
        $locations = DB::table('riding_charter_users')->select('name', 'latitude', 'longitude')->get();
        $params = [
            'users' => $users,
            'ridingCharter' => $ridingCharters,
            'products' => $products,
            'categories' => $categories,
            'locations' => $locations
        ];
        return view('admin.app', $params);
    }

    public function logout()
    {
        session()->forget('adminId');
        return redirect()->route('admin.login');
    }

}

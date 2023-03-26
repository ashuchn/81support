<?php

namespace App\Http\Controllers\subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riding_Charter_User;
use Session;
use DB;
use Validator;
use Hash;
use stdClass;
use Auth;

class AuthController extends Controller
{
    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|exists:riding_charter_users',
            'password' =>'required'
        ], [
            'required' =>':attribute is required',
            'email.exists' =>':attribute does not exist',
        ]);
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        $checkStatus = Riding_Charter_User::where(['email'=>$request->email])->first();
        if($checkStatus->status == 0) {
            return back()->with('err_msg', 'Your account is deactivated. Please contact admin.');
        }
        $checkEmail = Riding_Charter_User::where(['email'=>$request->email])->first();
        if( !$checkEmail || !Hash::check($request->password , $checkEmail->password)) {
            return back()->with('err_msg', 'Invalid Email or Password');
        } else {
            session()->put('subadminId', $checkEmail->id);
            return redirect()->route('subadmin.dashboard');
        }
    }

    public function dashboard()
    {
        return view('subadmin.dashboard');
    }

    public function orders($id) {
        $orders = DB::table('orders')->where('userId', $id)->get();
        $mapped = $orders->map(function($order) {
            $product = DB::table('products')->where('products.id', $order->productId)->get();
            $productImages = DB::table('product_images')->where('productId', $order->productId)->pluck('image');
            
            $url = $productImages->map(function($image){
                $baseurl = url('/');
                return $baseurl.'/'.$image; 
            });
            
            $order->product = $product[0];
            $order->product->images = $url;

            return $order;
        });

        return $mapped;
    }


    public function logout()
    {
        session()->forget('subadminId');
        return redirect()->route('subadmin.login');
    }
}

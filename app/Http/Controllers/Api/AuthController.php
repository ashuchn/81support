<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use Validator;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller {


    public function test()
    {
        return "test";
    }

    public function login( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'email' =>'required|email|exists:new_users',
            'password' =>'required'
        ], [
            'required' =>':attribute is required',
            'email.exists' =>':attribute does not exist',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ],401 );
        }

        $checkEmail = New_User::where( ['email'=>$request->email] )->first();
        if ( !$checkEmail || !Hash::check( $request->password, $checkEmail->password ) ) {
            return response()->json( [
                'response_message' => 'Invalid Credentials',
                'response_code' => 401
            ],401 );
        } else {
            
            $token = $checkEmail->createToken($request->email);
            return response()->json( [
                'response_message' => 'Ok',
                'response_code' => 200,
                'token' => $token->plainTextToken,
                'data' => $checkEmail
            ],200 );
        }
    }

    public function signup( Request $request ) 
    {
        // return $request;
        $validator = Validator::make( $request->all(), [
            'name'=>'required|max:100|min:0',
            'mobile'=>'required|max:10|min:0|unique:new_users',
            'email' => 'required|email|max:100|min:0|unique:new_users',
            'password' => 'required|max:100|min:0',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ],401 );
        }

        $userprofile = new New_User;
        $userprofile->name = $request->name;
        $userprofile->email = $request->email;
        $userprofile->mobile = $request->mobile;
        $userprofile->password = Hash::make( $request->password );
        $userprofile->dob = $request->dob;
        $userprofile->status = '0';
        if($userprofile->save()) {
            $token = $userprofile->createToken($request->email)->plainTextToken;
            return response()->json( [
                "response_message" => "User Added",
                "response_code"    => 200,
                "token"            => $token,
                "data"             => $userprofile
            ], 200);
        } else {
            return response()->json( [
                "response_message" => "Some error Occured",
                "response_code"    => 401
            ], 401);
        }
    }

    
    
    public function authenticate(Request $req)
    {
        return response()->json([
            'response_message' => 'Ok',
            'response_code' => 200,
            'data' => $req->user()
        ], 200);
    }


    /**
     * forgot password
     */

    public function checkEmailExist(Request $req)
    {
        $validator = Validator::make( $req->all(), [
            'email' => 'required|email|exists:new_users',
        ],[
            'email.required' => ':attribute is required',
            'email.email' => 'Incorrect :attribute Format',
            'email.exists' => ':attribute does not exists'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ],401 );
        }

        $otp = mt_rand(1000,9999);
        \Mail::to($req->email)->send(new \App\Mail\sendOtp($otp));
        $update = New_User::where('email', $req->email)->update([ "otp" => $otp ]);
        return response()->json( [
            "response_message" => "otp sent!",
            "response_code" => 200
        ],200 );
    }


}

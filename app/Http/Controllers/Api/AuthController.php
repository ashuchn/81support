<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use Validator;
use Hash;
use DB;
use Mail;

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
            ] );
        }

        $checkEmail = New_User::where( ['email'=>$request->email] )->first();
        if ( !$checkEmail || !Hash::check( $request->password, $checkEmail->password ) ) {
            return response()->json( [
                'response_message' => 'Invalid Credentials',
                'response_code' => 401
            ] );
        } else {
            
            $token = $checkEmail->createToken($request->email);
            return response()->json( [
                'response_message' => 'Ok',
                'response_code' => 200,
                'token' => $token->plainTextToken,
                'data' => $checkEmail
            ] );
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
            ] );
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
            ]);
        } else {
            return response()->json( [
                "response_message" => "Some error Occured",
                "response_code"    => 401
            ]);
        }
    }

    //forgot password

    public function sendOtp( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'email' => 'required|email'

        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ] );

        }

        $userprofile = New_User::where( ['email'=>$request->email] )->first();

        if ( !isset( $userprofile ) ) {

            return response()->json( [
                'response_message' => 'Invalid email',
                'response_code' => 401
            ] );
        } else {
            //otp
            $length = 6;
            $characters = '0123456789';
            $charactersLength = strlen( $characters );
            $randomString = '';
            for ( $i = 0; $i < $length; $i++ ) {
                $randomString .= $characters[rand( 0, $charactersLength - 1 )];
            }
            $randomString;
            
            $userprofile->otp = $randomString;
            $userprofile->save();
            return response()->json( [
                'response_message' => 'ok',
                'response_code' => 200,
                'data'=> $randomString,
            ] );
        }
    }

    
    public function verify( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'otp' => 'required',
            'email' => 'required|email'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ] );

        }

        $userprofile = New_User::where( ['email'=>$request->email] )->first();

        if ( !isset( $userprofile ) || ( $request->otp != $userprofile->otp ) ) {

            return response()->json( [
                'response_message' => 'Invalid otp',
                'response_code' => 401
            ] );
        } else {
            $userprofile->otp = NULL;
            $userprofile->save();
            return response()->json( [
                'response_message' => 'otp Match',
                'response_code' => 200,
            ] );
        }

    }
    

    public function change_password( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'password' => 'required|min:8|max:100',
            'email' => 'required|email|exists:new_users'

        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ] );

        }

        $userprofile = New_User::where( ['email'=>$request->email] )->first();

        $userprofile->password = Hash::make( $request->password );
        $userprofile->save();
        return response()->json( [
            'response_message' => 'Password Updated',
            'response_code' => 200,
        ] );

    }
    
    public function authenticate(Request $req)
    {
        return response()->json([
            'response_message' => 'Ok',
            'response_code' => 200,
            'data' => $req->user()
        ], 200);
    }

}

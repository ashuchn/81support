<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use Mail;
use Validator;
use Hash;
use DB;

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
        Mail::to($req->email)->send(new \App\Mail\sendOtp($otp));
        $update = New_User::where('email', $req->email)->update([ "otp" => $otp ]);
        return response()->json( [
            "response_message" => "otp sent!",
            "response_code"    => 200,
            "otp"              => $otp 
        ],200 );
    }


    public function verifyOtp(Request $req)
    {
        $validator = Validator::make( $req->all(), [
            'email' => 'required|email|exists:new_users',
            'otp'   => 'required|max:4'
        ],[
            'email.required' => ':attribute is required',
            'email.email'    => 'Incorrect :attribute Format',
            'email.exists' => ':attribute does not exists',
            'otp.required'   => ':attribute is required',
            'otp.max'        => 'Only 4 digits :attribute accepted',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ],401 );
        }

        $data = New_User::where('email', $req->email)->first();
        if($data->otp == $req->otp) {
            return response()->json( [
                "response_message" => "otp matched!",
                "response_code" => 200
            ],200 );
        } else {
            return response()->json( [
                'response_message' => "otp not matched",
                'response_code' => 401
            ],401 );
        }

    }


    public function changePassword(Request $req)
    {
        $validator = Validator::make( $req->all(), [
            'email'      => 'required|email|exists:new_users',
            'password'   => 'required'
        ],[
            'email.required' => ':attribute is required',
            'email.email'    => 'Incorrect :attribute Format',
            'email.exists' => ':attribute does not exists',
            'password.required'   => ':attribute is required',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'response_message' => $validator->messages()->first(),
                'response_code' => 401
            ],401 );
        }

        $update = New_User::where('email', $req->email)->update([ "password" => Hash::make($req->password) ]);
        if($update) {
            return response()->json( [
                "response_message" => "Password Changed!",
                "response_code" => 200
            ],200 );
        } else {
            return response()->json( [
                "response_message" => "Some error occured!",
                "response_code" => 401
            ],401 );
        }

    }


    public function fcm(Request $request)
  {
    $server_key = env('FIREBASE_SERVER_KEY');

    // Prep the Bundle
    $msg = [
      'message' => $request->message,
    ];
    $notify_data = [
      'body' => $request->message,
      'title' => $request->title,
    ];
    $registration_ids = $request->tokens;

    if (count($request->tokens) > 1) {
      // For Multiple Users
      $fields = [
        'registration_ids' => $registration_ids,
        'notification' => $notify_data,
        'data' => $msg,
        'priority' => 'high'
      ];
    } else {
      // For Single User
      $fields = [
        'to' => $registration_ids[0],
        'notification' => $notify_data,
        'data' => $msg,
        'priority' => 'high'
      ];
    }

    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key=' . $server_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if ($result === FALSE) {
      return [
        'result' => false,
        'message' => curl_error($ch)
      ];
    }
    curl_close($ch);
    return [
      'result' => true,
      'message' => $result,
    ];
  }

}

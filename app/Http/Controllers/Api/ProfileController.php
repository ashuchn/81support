<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use Validator;
use Hash;
use DB;
use Mail;

class ProfileController extends Controller {
    
     public function update( Request $request ) {
        
        $id = $request->id;

        $userprofile = New_User::find( $id );
        $userprofile->name = $request->name;
        $userprofile->email = $request->email;
        $userprofile->mobile = $request->mobile;
        $userprofile->dob = $request->dob;
        $userprofile->image = $request->image;
        $userprofile->save();
        return response()->json( [
            'response_message' => 'Profile Updated',
            'response_code' => 200,
        ] );
    }

    public function addAddress( Request $request ) {
        $id = $request->user()->id;
        $userprofile = New_User::find( $id );
        $userprofile->address = $request->address;
        $userprofile->save();
        return response()->json( [
            'response_message' => 'Address Added',
            'response_code' => 200,
        ] );
    }

    public function getAddress( Request $request ) {
        $id = $request->user()->id;
        $userprofile = New_User::find( $id );
        return response()->json( [
            'response_message' => 'Address Added',
            'response_code' => 200,
            'data' => $userprofile->address,
        ] );
    }

    public function updateAddress( Request $request ) {
        $id = $request->user()->id;
        $userprofile = New_User::find( $id );
        $userprofile->address = $request->address;
        $userprofile->save();
        return response()->json( [
            'response_message' => 'Address Updated',
            'response_code' => 200,
        ] );
    }
    
}

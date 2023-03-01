<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\New_User;
use App\Models\Address;
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

        $valid = Validator::make($request->all(),[
            "first_name" => "required",
            "last_name" => "required",
            "mobile" => "required",
            "address_line_1" => "required",
            "country" => "required",
        ],[
            "first_name.required" => "First Name is required",
            "last_name.required" => "Last Name is required",
            "mobile.required" => "Mobile is required",
            "address_line_1.required" => "Address Line 1 is required",
            "country.required" => "Country is required",
        ]);
 
        $add = new Address;
        $add->user_id = $id;
        $add->first_name = $request->first_name;
        $add->last_name = $request->last_name;
        $add->mobile = $request->mobile;
        $add->address_line_1 = $request->address_line_1;
        $add->address_line_2 = $request->address_line_2;
        $add->country = $request->country;
        $add->save();

        return response()->json( [
            'response_message' => 'Address Added',
            'response_code' => 200,
        ] );
    }

    public function getAddress( Request $request ) {
        $id = $request->user()->id;
        $add = Address::where( 'user_id', $id )->get();
        return response()->json( [
            'response_message' => 'Address Added',
            'response_code' => 200,
            'data' => $add,
        ] );
    }

    public function editAddress( Request $request ) {
        $id = $request->id;
        $add = Address::find( $id );
        return response()->json( [
            'response_code' => 200,
            'data' => $add,
        ] );
    }

    public function updateAddress( Request $request ) {
        $id = $request->id;

        $valid = Validator::make($request->all(),[
            "first_name" => "required",
            "last_name" => "required",
            "mobile" => "required",
            "address_line_1" => "required",
            "country" => "required",
        ],[
            "first_name.required" => "First Name is required",
            "last_name.required" => "Last Name is required",
            "mobile.required" => "Mobile is required",
            "address_line_1.required" => "Address Line 1 is required",
            "country.required" => "Country is required",
        ]);

        $add = Address::find( $id );
        $add->first_name = $request->first_name;
        $add->last_name = $request->last_name;
        $add->mobile = $request->mobile;
        $add->address_line_1 = $request->address_line_1;
        $add->address_line_2 = $request->address_line_2;
        $add->country = $request->country;
        $add->save();
        return response()->json( [
            'response_message' => 'Address Updated',
            'response_code' => 200,
        ] );
    } 
    
    
}

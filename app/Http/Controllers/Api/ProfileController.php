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

    public function getProfile( Request $request ) {
        $id = $request->user()->id;
        $user = New_User::where( 'id', $id )->first(['id','name','email','mobile','image']);
        return response()->json( [
            'response_message' => 'Profile',
            'response_code' => 200,
            'data' => $user,
        ] );
    }
    
     public function updateProfile( Request $request ) {
        
        $id = $request->user()->id;

        $userprofile = New_User::find( $id );
        if($request->has('name')){
            $userprofile->name = $request->name;
        }else{
            $userprofile->name = $userprofile->name;
        }
        if($request->has('email')){
            $userprofile->email = $request->email;
        }else{
            $userprofile->email = $userprofile->email;
        }
        if($request->has('mobile')){
            $userprofile->mobile = $request->mobile;
        }else{
            $userprofile->mobile = $userprofile->mobile;
        }
        if($request->has('dob')){
            $userprofile->dob = $request->dob;
        }else{
            $userprofile->dob = $userprofile->dob;
        }
        if($request->has('image')){
            $userprofile->image = $request->image;
        }else{
            $userprofile->image = $userprofile->image;
        }
        $userprofile->save();
        return response()->json( [
            'response_message' => 'Profile Updated',
            'response_code' => 200,
        ] );
    }

    public function addAddress( Request $request ) {
        $id = $request->user()->id;

        $valid = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile'=>'required|max:10|min:0',
            'address_line_1' => 'required',
            'country' => 'required',
        ],[
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'mobile.required' => 'Mobile is required',
            'mobile.max' => 'Mobile must be 10 digits',
            'mobile.min' => 'Mobile must be 10 digits',
            'address_line_1.required' => 'Address Line 1 is required',
            'country.required' => 'Country is required',
        ]);

        if($valid->fails()) {
            return response()->json([
                'response_message' => $valid->errors()->first(),
                'response_code'    => 401,
            ],401);
        }
 
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
        $valid = Validator::make($request->all(),[
            'id' => 'required|exists:Address'
        ],[
            'id.required' => 'Id is required',
            'id.esists' => 'No address found'
        ]);

        if($valid->fails()) {
            return response()->json([
                'response_message' => $valid->errors()->first(),
                'response_code'    => 401,
            ],401);
        }

        $add = Address::find( $id );
        return response()->json( [
            'response_code' => 200,
            'data' => $add,
        ] );
    }

    public function updateAddress( Request $request ) {
        $id = $request->id;

        $valid = Validator::make($request->all(),[
            'id' => 'required|exists:user_address',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile'=>'required|max:10|min:0',
            'address_line_1' => 'required',
            'country' => 'required',
        ],[
            'id.required' => 'Id is required',
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'mobile.required' => 'Mobile is required',
            'mobile.max' => 'Mobile must be 10 digits',
            'mobile.min' => 'Mobile must be 10 digits',
            'address_line_1.required' => 'Address Line 1 is required',
            'country.required' => 'Country is required',
        ]);

        if($valid->fails()) {
            return response()->json([
                'response_message' => $valid->errors()->first(),
                'response_code'    => 401,
            ],401);
        }

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

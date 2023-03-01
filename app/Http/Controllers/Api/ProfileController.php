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
    
}

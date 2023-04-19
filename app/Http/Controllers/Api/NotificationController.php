<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Validator;
use Hash;
use DB;
use Mail;

class NotificationController extends Controller {
    
    public function getNotifications(Request $req)
    {
        $user_id = $req->user()->id;
        
        $data = Notification::where('user_id', $user_id)->get() ?? [];
        
        if($data->count() == 0){
            return response()->json([
                "response_code"    => 404,
                "response_message" => "No Notification Found",
            ]);
        }else{
            return response()->json([
                "response_code"    => 200,
                "response_message" => "Ok",
                "data"         => $data
            ]);
        }
    }
    
}

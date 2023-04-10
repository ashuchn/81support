<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Vallidator;

class ProductDetails extends Controller {
    
    public function ProductDetails(Request $req)
    {
        $valid = Validator::make($req->all(),[
            "productId" => "Required|exists:products,id",
        ],[
            "productId.required" => "Provide Product Id",
            "productId.exists"   => "Product Id not Found"
        ]);

        if($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code"    => 401,
            ],401);
        }
        
        $data = Product::find($req->productId);
        $totalRatings = DB::table('reviews')->where('productId',$data->id)->count();
        if($totalRatings > 0) {
            $ratings = DB::table('reviews')->where('productId',$data->id)->sum('rating');
            $avgRating = $ratings/$totalRatings;
        } else {
            $avgRating = 0;
        }
        $data->avgRating = $avgRating;
        $images = DB::table('product_images')->where('productId',$data->id)->pluck('image');
        if(isset($images)) {
            $img = $images->map(function($im){
                return url('/').'/'.$im; 
            });
        }
        $data->image = $img;
        
        $reviews = DB::table('reviews')->where('productId',$data->id)->get(['id','userId','productId','rating','description']);
        if(isset($reviews)) {
            $review = $reviews->map(function($rv){
                 $user = New_User::find($rv->userId);
                 if($user) {
                    $rv->userName = $user->name;
                    $rv->userImage = $user->image;
                 } else {
                    $rv->userName = null;
                    $rv->userImage = null;
                 }
                 return $rv;
            });
        } else {
            $review = [];
        }
        
        $data->reviews = $review;
        return response()->json([
            "response_message" => "Ok!",
            "response_code"    => 200,
            "data"             => $data
        ],200);   
    }
    
}

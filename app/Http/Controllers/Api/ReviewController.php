<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Validator;
use DB;
use Session;
use Auth;

class ReviewController extends Controller
{
   public function getReview(Request $request) {
        $id = $request->user()->id;
        if($request->has('stars')){
            $stars = $request->stars;
            $reviews = DB::table('reviews')
            ->join('products', 'reviews.productId', '=', 'products.id')
            ->select('reviews.*', 'products.productName as productName')
            ->where('reviews.userID', $id)
            ->where('reviews.rating', $stars)
            ->get();
        }else{
            $reviews = DB::table('reviews')
            ->join('products', 'reviews.productId', '=', 'products.id')
            ->select('reviews.*', 'products.productName as productName')
            ->where('reviews.userID', $id)
            ->get();
        }if($reviews->isNotEmpty()){
            return response()->json( [
                'response_code' => 200,
                'data' => compact('reviews'),
            ] );
        }else{
            return response()->json( [
                'response_code' => 401,
                'response_messege' => 'No Reviews Found',
            ] );
        }
   }
}

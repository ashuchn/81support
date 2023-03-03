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
   public function getReview() {
        $id = session()->get('subadminId');
        $reviews = DB::table('reviews')
            ->join('products', 'reviews.productId', '=', 'products.id')
            ->select('reviews.*', 'products.productName as productName')
            ->where('reviews.userID', $rid)
            ->get();
        return response()->json( [
            'response_code' => 200,
            'rc_id' => $rc_id,
            'data' => compact('reviews'),
        ] );
   }
}

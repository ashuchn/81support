<?php

namespace App\Http\Controllers\subadmin;

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
        $rc_id = session()->get('subadminId');
        $reviews = DB::table('reviews')
            ->join('products', 'reviews.productId', '=', 'products.id')
            ->select('reviews.*', 'products.productName as productName')
            ->where('products.rc_id', $rc_id)
            ->get();
        return view('subadmin.reviews.index', compact('reviews'));
   }
}

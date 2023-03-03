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
        $id = Auth::user()->id;
        $reviews = DB::table('reviews')
        ->join('products', 'reviews.productId', '=', 'products.id')
        ->join('users', 'reviews.userId', '=', 'users.id')
        ->select('reviews.*', 'products.name as product_name', 'users.name as user_name')
        ->where('reviews.userId', $id)
        ->get();
        return view('subadmin.reviews.index', compact('reviews'));
   }
}

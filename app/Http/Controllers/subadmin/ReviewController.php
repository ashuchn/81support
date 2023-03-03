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
        $id = Auth::id();
        $reviews = DB::table('reviews')
        ->where('reviews.userId', $id)
        ->get();
        return view('subadmin.reviews.index', compact('reviews'));
   }
}

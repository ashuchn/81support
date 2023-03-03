<?php

namespace App\Http\Controllers\subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Validator;
use DB;
use Session;

class ReviewController extends Controller
{
   public function getReview() {
        return(view('subadmin.reviews.index'));
   }
}

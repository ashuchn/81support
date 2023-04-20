<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\New_User;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductSizeQuantity;
use DB;
use Illuminate\Http\Request;
use Validator;

/**
 * Summary of ProductDetails
 */
class ProductDetails extends Controller
{

    public function ProductDetailsV1(Request $req)
    {
        $id = $req->id;
        $category = Category::all();
        $product = Product::find($id);
        $productImages = DB::table('product_images')->where('productId', $id)->pluck('image');

        $totalColors = ProductSizeQuantity::where('product_id', $id)->distinct('color')->count('color');
        $totalQty = ProductSizeQuantity::where('product_id', $id)->count('color');
        $colors = ProductSizeQuantity::where('product_id', $id)->select('color')->groupBy('color')->get();
        $sizes = ProductSizeQuantity::where('product_id', $id)->select('size')->groupBy('size')->get();

        for ($i = 0; $i < $totalColors; $i++) {
            for ($j = 0; $j < $totalQty / $totalColors; $j++) {
                $rows[$i][$j] = ProductSizeQuantity::where('product_id', $id)->where('color', $colors[$i]->color)->where('size', $sizes[$j]->size)->first();
            }
        }

        $data = Product::find($req->id);
        $totalRatings = DB::table('reviews')->where('productId', $data->id)->count();
        if ($totalRatings > 0) {
            $ratings = DB::table('reviews')->where('productId', $data->id)->sum('rating');
            $avgRating = $ratings / $totalRatings;
        } else {
            $avgRating = 0;
        }
        $data->avgRating = $avgRating;
        $images = DB::table('product_images')->where('productId', $data->id)->pluck('image');
        if (isset($images)) {
            $img = $images->map(function ($im) {
                return url('/') . '/' . $im;
            });
        }
        $data->image = $img;

        $reviews = DB::table('reviews')->where('productId', $data->id)->get(['id', 'userId', 'productId', 'rating', 'description']);
        $review = (isset($reviews)) ? $reviews->map(function ($rv) {
            $user = New_User::find($rv->userId);
            if ($user) {
                $rv->userName = $user->name;
                $rv->userImage = $user->image;
            } else {
                $rv->userName = null;
                $rv->userImage = null;
            }
            return $rv;
        }) : [];

        return response()->json([
            "response_message" => "Ok!",
            "response_code" => 200,
            "data" => $data,
        ], 200);
    }

    /**
     * Summary of ProductDetails
     * @param Request $req
     * @return mixed
     */
    public function ProductDetails(Request $req)
    {
        $productId = $req->productId;
        $data = Product::find($req->productId);
        if ($data == null) {
            return response()->json([
                "response_message" => "Product not found!",
                "response_code" => 404,
                "data" => null,
            ], 404);
        }

        // Colors
        $psq = ProductSizeQuantity::where('product_id', $productId)->first();
        $cols = ProductSizeQuantity::where('product_id', $productId)->select('color')->groupBy('color')->get();
        foreach ($cols as $key => $value) {
            $cols[$key]->name = DB::table('colors')->where('id', $value->color)->first()->name;
            $cols[$key]->hex = DB::table('colors')->where('id', $value->color)->first()->hex;
        }
        $colors = $cols;
        $curr_color = (isset($req->color)) ? $req->color : ((isset($psq->color)) ? $psq->color : null);
        $current_color['color'] = (isset($curr_color)) ? DB::table('colors')->where('id', $curr_color)->first()->id : null;
        $current_color['name'] = (isset($curr_color)) ? DB::table('colors')->where('id', $curr_color)->first()->name : null;
        $current_color['hex'] = (isset($curr_color)) ? DB::table('colors')->where('id', $curr_color)->first()->hex : null;

        $data->available_colors = $colors;
        $data->current_color = $current_color;

        // Ratings
        $totalRatings = DB::table('reviews')->where('productId', $data->id)->count();
        if ($totalRatings > 0) {
            $ratings = DB::table('reviews')->where('productId', $data->id)->sum('rating');
            $avgRating = $ratings / $totalRatings;
        } else {
            $avgRating = 0;
        }
        //  float 
        $data->avgRating = number_format( (float) $avgRating, 1, '.', '');

        // Images
        $images = DB::table('product_images')->where('productId', $data->id)->where('color', $current_color['color'])->pluck('image');
        if (isset($images)) {
            $img = $images->map(function ($im) {
                return url('/') . '/' . $im;
            });
        }
        $data->image = $img;

        // Reviews
        $reviews = DB::table('reviews')->where('productId', $data->id)->get(['id', 'userId', 'productId', 'rating', 'description']);
        $review = (isset($reviews)) ? $reviews->map(function ($rv) {
            $user = New_User::find($rv->userId);
            if ($user) {
                $rv->userName = $user->name;
                $rv->userImage = $user->image;
            } else {
                $rv->userName = null;
                $rv->userImage = null;
            }
            return $rv;
        }) : [];
        $data->reviews = $review;

        // Sizes
        $sizes = ProductSizeQuantity::where('product_id', $productId)->where('color', $current_color)->select('size')->groupBy('size')->get();
        if (count($sizes) > 0) {
            foreach ($sizes as $key => $value) {
                $sizes[$key]->initial = DB::table('sizes')->where('id', $value->size)->first()->size;
                $sizes[$key]->quantity = ProductSizeQuantity::where('product_id', $productId)->where('color', $current_color['color'])->where('size', $value->size)->first()->quantity;
            }
            $data->sizes = $sizes;
        } else {
            $data->sizes = [];
        }

        return response()->json([
            "response_message" => "Ok!",
            "response_code" => 200,
            "product" => $data,
        ], 200);
    }

}
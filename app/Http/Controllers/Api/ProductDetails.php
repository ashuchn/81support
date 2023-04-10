<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductSizeQuantity;
use DB;
use Illuminate\Http\Request;
use Validator;

class ProductDetails extends Controller
{

    public function ProductDetails(Request $req)
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

        $data = Product::find($req->productId);
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
        if (isset($reviews)) {
            $review = $reviews->map(function ($rv) {
                $user = New_User::find($rv->userId);
                if ($user) {
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

        return response()->json([
            "response_message" => "Ok!",
            "response_code" => 200,
            "data" => [
                "rows" => compact('rows', 'data'),
            ],
        ], 200);
    }

}
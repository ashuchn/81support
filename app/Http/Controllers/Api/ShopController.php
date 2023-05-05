<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riding_Charter_User;
use App\Models\Product;
use App\Models\ProductSizeQuantity;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Bookmark;
use App\Models\New_User;
use App\Models\Deal;
use Validator;
use Hash;
use DB;
use Mail;

class ShopController extends Controller
{

    // completed

    public function allProducts(Request $req)
    {

        $valid = Validator::make($req->all(), [
            "shopId" => "Required|exists:products,rc_id",
        ], [
                "shopId.required" => "Provide Shop Id",
                "shopId.exists" => "No Product Found"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $category = $req->category;
        $price = $req->price;
        $searchText = $req->searchText;

        if($category != null || $price != null || $searchText != null){
            $data = Product::where('rc_id', $req->shopId)->orwhere('categoryId', $category)->orwhere('price', '<=', $price)->orwhere('productName', 'LIKE', "%{$searchText}%")->paginate(10)->through(function ($dt) {

                $images = DB::table('product_images')->where('productId', $dt->id)->pluck('image');
                $urlImages = $images->map(function ($img) {
                    $img = url('/') . '/' . $img;
                    return $img;
                });
                $dt->images = $urlImages;

                $category = Category::where('id', $dt->categoryId)->first();

                return $dt->addedProduct = [
                    'id' => $dt->id,
                    'productName' => $dt->productName,
                    'category' => $category->categoryName,
                    'price' => $dt->price,
                    'description' => $dt->description,
                    'images' => $urlImages,
                ];
            });
        }

        $data = Product::where('rc_id', $req->shopId)->paginate(10)->through(function ($dt) {

            $images = DB::table('product_images')->where('productId', $dt->id)->pluck('image');
            $urlImages = $images->map(function ($img) {
                $img = url('/') . '/' . $img;
                return $img;
            });
            $dt->images = $urlImages;

            $category = Category::where('id', $dt->categoryId)->first();

            return $dt->addedProduct = [
                'id' => $dt->id,
                'productName' => $dt->productName,
                'category' => $category->categoryName,
                'price' => $dt->price,
                'description' => $dt->description,
                'images' => $urlImages,
            ];
        });

        return response()->json([
            "response_code" => 200,
            "response_message" => "Ok",
            "products" => $data
        ]);
    }

    // Bookmark

    public function getBookmarks(Request $req)
    {
        $userId = $req->user()->id;
        $data = Bookmark::where('userId', $userId)->get(['id as bookmarkId', 'productId']);
        $bookmarkCount = count($data);

        if ($bookmarkCount > 0) {
            $bookmark = $data->map(function ($dt) {
                $product = Product::where('id', $dt->productId)->first();

                $images = DB::table('product_images')->where('productId', $product->id)->pluck('image');
                $urlImages = $images->map(function ($img) {
                    $img = url('/') . '/' . $img;
                    return $img;
                });

                $dt->addedProduct = [
                    'id' => $product->id,
                    'productName' => $product->productName,
                    'price' => $product->price,
                    'description' => $product->description,
                    'images' => $urlImages,
                ];

                unset($dt->userId);
                unset($dt->productId);
                return $dt;
            });

            return response()->json([
                "response_message" => "Ok!",
                "response_code" => 200,
                "bookmarkProductCount" => count($bookmark),
                "data" => $bookmark,

            ], 200);
        } else {
            return response()->json([
                "response_message" => "No products in Bookmarks",
                "response_code" => 404,
            ], 404);
        }
    }

    public function bookmarkProduct(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "productId" => "Required",
        ], [
                "productId.required" => "Provide Product Id",
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $userId = $req->user()->id;
        $exists = Bookmark::where('userId', $userId)->where('productId', $req->productId)->exists();

        if (!$exists) {
            $insert = new Bookmark;
            $insert->productId = $req->productId;
            $insert->userId = $userId;
            $insert->color = $req->color;
            if ($insert->save()) {
                return response()->json([
                    "response_message" => "Bookmark Added",
                    "response_code" => 200,
                ], 200);
            } else {
                return response()->json([
                    "response_message" => "Some error Occured",
                    "response_code" => 401,
                ], 401);
            }
        } else {
            return response()->json([
                "response_message" => "Already Bookmarked",
                "response_code" => 401,
            ], 401);
        }


    }

    public function deleteBookmarkedProduct(Request $req)
    {
        $id = $req->bookmarkId;

        if ($id == NULL || $id == '') {
            return response()->json([
                "response_message" => "Bookmark Id is Required",
                "response_code" => 401,
            ], 401);
        }

        $userId = $req->user()->id;
        $bookmark = Bookmark::find($id);

        if ($bookmark == NULL) {
            return response()->json([
                "response_message" => "No Product Found",
                "response_code" => 404,
            ], 404);
        } else {
            $bookmark->delete();
            $remaining = Bookmark::where('userId', $userId)->get();
            return response()->json([
                "response_message" => "Product Deleted from Bookmarks",
                "response_code" => 200,
                "data" => $remaining,
            ], 200);
        }
    }

    // Cart

    public function getCart(Request $req)
    {
        $userId = $req->user()->id;
        $data = Cart::where('userId', $userId)->get(['id as cartId', 'productId', 'userId', 'quantity']);
        $cartProductCount = count($data);

        if ($cartProductCount > 0) {
            $cart = $data->map(function ($dt) {
                $product = Product::where('id', $dt->productId)->first();

                $images = DB::table('product_images')->where('productId', $dt->productId)->pluck('image');
                $urlImages = $images->map(function ($img) {
                    $img = url('/') . '/' . $img;
                    return $img;
                });
                $product->images = $urlImages;

                $dt->addedProduct = [
                    'id' => $product->id,
                    'productName' => $product->productName,
                    'price' => $product->price,
                    'description' => $product->description,
                    'images' => $urlImages,
                ];

                unset($dt->userId);
                unset($dt->productId);
                return $dt;
            });
            return response()->json([
                "response_message" => "Ok!",
                "response_code" => 200,
                "cartProductCount" => count($cart),
                "data" => $cart->all()
            ], 200);
        } else {
            return response()->json([
                "response_message" => "No products in Cart",
                "response_code" => 404,
            ], 404);
        }
    }

    public function addProductToCart(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "productId" => "Required",
            "quantity" => "Required"
        ], [
                "productId.required" => "Provide Product Id",
                "quantity.required" => "Provide Product Quantity",
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $userId = $req->user()->id;
        $exists = Cart::where('userId', $userId)->where('productId', $req->productId)->exists();

        $available_quantity = ProductSizeQuantity::where('product_id', $req->productId)->where('color', $req->color)->where('size', $req->size)->first()->quantity;
        if ($available_quantity < $req->quantity) {
            return response()->json([
                "response_message" => "Quantity not available",
                "response_code" => 401,
            ], 401);
        }

        if (!$exists) {
            $insert = new Cart;
            $insert->productId = $req->productId;
            $insert->userId = $userId;
            $insert->quantity = $req->quantity;
            $insert->color = $req->color;
            $insert->size = $req->size;
            if ($insert->save()) {
                return response()->json([
                    "response_message" => "Added to Cart!",
                    "response_code" => 200,
                ], 200);
            } else {
                return response()->json([
                    "response_message" => "Some error Occured",
                    "response_code" => 401,
                ], 401);
            }
        } else {
            return response()->json([
                "response_message" => "Already Added to cart",
                "response_code" => 401,
            ], 401);
        }
    }

    public function increaseCartProductCount(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "cartId" => "Required|exists:carts,id",
        ], [
                "cartId.required" => "Provide cart Id",
                "cartId.exists" => "No Products in Cart"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $cart = Cart::where('id', $req->cartId)->first();
        $size = $cart->size;
        $color = $cart->color;
        $productId = $cart->productId;
        $qty = $cart->quantity;
        $available_quantity = ProductSizeQuantity::where('product_id', $productId)->where('color', $color)->where('size', $size)->first()->quantity;

        if ($available_quantity <=  $qty) {
            return response()->json([
                "response_message" => "Quantity not available",
                "response_code" => 401,
            ], 401);
        }

        $increment = Cart::where('id', $req->cartId)->increment('quantity', 1);
        if ($increment) {

            $userId = $req->user()->id;
            $data = Cart::where('userId', $userId)->get(['id as cartId', 'productId', 'userId', 'quantity']);
            $cartProductCount = count($data);

            $cart = $data->map(function ($dt) {
                $product = Product::where('id', $dt->productId)->first();
                $images = DB::table('product_images')->where('productId', $dt->productId)->pluck('image');
                $urlImages = $images->map(function ($img) {
                    $img = url('/') . '/' . $img;
                    return $img;
                });
                $product->images = $urlImages;

                $reviews = DB::table('reviews')->where('productId', $dt->productId)->get(['id', 'userId', 'productId', 'rating', 'description']);
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
                $product->reviews = $reviews;
                $dt->addedProduct = $product;
                unset($dt->userId);
                unset($dt->productId);
                return $dt;
            });

            return response()->json([
                "response_message" => "Ok!",
                "response_code" => 200,
                "cartProductCount" => $cartProductCount,
                "data" => $cart
            ]);
        }

    }

    public function decreaseCartProductCount(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "cartId" => "Required|exists:carts,id",
        ], [
                "cartId.required" => "Provide cart Id",
                "cartId.exists" => "No Products in Cart"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $cart = Cart::where('id', $req->cartId)->first();
        $qty = $cart->quantity;

        if ($qty == 1) {
            $cart->delete();
            return response()->json([
                "response_message" => "Product deleted from cart",
                "response_code" => 200,
            ], 200);
        }

        $decrement = Cart::where('id', $req->cartId)->decrement('quantity', 1);
        if ($decrement) {

            $userId = $req->user()->id;
            $data = Cart::where('userId', $userId)->get(['id as cartId', 'productId', 'userId', 'quantity']);
            $cartProductCount = count($data);

            $cart = $data->map(function ($dt) {
                $product = Product::where('id', $dt->productId)->first();
                $images = DB::table('product_images')->where('productId', $dt->productId)->pluck('image');
                $urlImages = $images->map(function ($img) {
                    $img = url('/') . '/' . $img;
                    return $img;
                });
                $product->images = $urlImages;

                $reviews = DB::table('reviews')->where('productId', $dt->productId)->get(['id', 'userId', 'productId', 'rating', 'description']);
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
                $product->reviews = $reviews;
                $dt->addedProduct = $product;
                unset($dt->userId);
                unset($dt->productId);
                return $dt;
            });

            return response()->json([
                "response_message" => "Ok!",
                "response_code" => 200,
                "cartProductCount" => $cartProductCount,
                "data" => $cart
            ]);
        }

    }

    public function removeProductFromCart(Request $req)
    {
        $id = $req->productId;
        if ($id == NULL || $id == '') {
            return response()->json([
                "response_message" => "Product Id is Required",
                "response_code" => 401,
            ], 401);
        }
        $product_id = $id;
        $userId = $req->user()->id;
        $product = Cart::where('userId', $userId)->where('productId', $product_id)->first();
        if ($product == NULL || $product == '') {
            return response()->json([
                "response_message" => "Product not found in cart",
                "response_code" => 404,
            ], 401);
        }
        $product->delete();
        $cart = Cart::where('userId', $userId)->get();
        if ($cart == NULL || $cart == '') {
            return response()->json([
                "response_message" => "Cart is Empty",
                "response_code" => 200,
                "data" => $cart
            ], 200);
        }
        return response()->json([
            "response_message" => "Product removed from cart",
            "response_code" => 200,
            "data" => $cart
        ], 200);
    }

    // rest all

    public function deleteBookmarkedProductV1(Request $req, $id)
    {
        if ($id == NULL || $id == '') {
            return response()->json([
                "response_message" => "Bookmark Id is Required",
                "response_code" => 401,
            ], 401);
        }

        $userId = $req->user()->id;

        $delete = Bookmark::find($id);
        if ($delete->delete()) {
            $userId = $req->user()->id;
            $data = Bookmark::where('userId', $userId)->get(['id as bookmarkId', 'productId']);
            $bookmarkCount = count($data);

            if ($bookmarkCount > 0) {
                $bookmark = $data->map(function ($dt) {
                    $product = Product::where('id', $dt->productId)->first();
                    $images = DB::table('product_images')->where('productId', $dt->productId)->pluck('image');
                    $urlImages = $images->map(function ($img) {
                        $img = url('/') . '/' . $img;
                        return $img;
                    });
                    $product->images = $urlImages;

                    $reviews = DB::table('reviews')->where('productId', $dt->productId)->get(['id', 'userId', 'productId', 'rating', 'description']);
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
                    $product->reviews = $reviews;
                    $dt->addedProduct = $product;
                    unset($dt->userId);
                    unset($dt->productId);
                    return $dt;
                });
                return response()->json([
                    "response_message" => "Ok!",
                    "response_code" => 200,
                    "bookmarkProductCount" => $bookmarkCount,
                    "data" => $bookmark
                ], 200);
            } else {
                return response()->json([
                    "response_message" => "No products in Bookmarks",
                    "response_code" => 404,
                ], 404);
            }
        } else {
            return response()->json([
                "response_message" => "Some error Occured",
                "response_code" => 401,
            ], 401);
        }

    }
    
    public function getNearestShops(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "lat" => "required",
            "long" => "required"
        ]);

        if ($valid->fails()) {
            return response()->json([
                'response_message' => $valid->messages()->first(),
                'response_code' => 401
            ]);
        }

        $shops = DB::Select(
            DB::raw("Select id, name as shopName, latitude, longitude,
            ( 6371 * acos( cos(radians(37) ) * cos( radians($req->lat) )
            * cos( radians($req->long) - radians(-122) ) + sin(radians(37) )
            * sin( radians($req->lat) ) ) ) As distance
            From riding_charter_users
            ORDER BY distance")
        );


        return response()->json([
            "response_message" => "Ok",
            "response_code" => 200,
            "data" => $shops
        ], 200);



    }

    public function getCategories()
    {

        $data = Category::get(['id', 'categoryName', 'categoryImage']);
        $dt = $data->map(function ($ct) {
            if ($ct->categoryImage != NULL || $ct->categoryImage != '') {
                $ct->categoryImage = url('/') . '/' . $ct->categoryImage;
            } else {
                $ct->categoryImage = NULL;
            }
            return $ct;
        });

        return response()->json([
            "response_message" => "Ok",
            "response_code" => 200,
            "data" => $dt
        ], 200);
    }

    public function getProduct(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "productId" => "Required|exists:products,id",
        ], [
                "productId.required" => "Provide Product Id",
                "productId.exists" => "Product Id not Found"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
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

        $data->reviews = $review;
        return response()->json([
            "response_message" => "Ok!",
            "response_code" => 200,
            "data" => $data
        ], 200);


    }

    public function getDeals(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "shopId" => "Required|exists:deals,rc_id",
        ], [
                "shopId.required" => "Provide Shop Id",
                "shopId.exists" => "No Deals Found"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }
        $shopId = $req->shopId;
        $data = Deal::where('rc_id', $shopId)->get();
        $deals = $data->map(function ($dt) {
            $p = Product::findorFail($dt->rc_id);
            $dt->productId = $p->id;
            return $dt;
        });
        return $deals;
    }

    public function getProductsByCategory(Request $req)
    {
        $valid = Validator::make($req->all(), [
            "categoryId" => "Required|exists:categories,id",
        ], [
                "categoryId.required" => "Provide Category Id",
                "categoryId.exists" => "No Products Found"
            ]);

        if ($valid->fails()) {
            return response()->json([
                "response_message" => $valid->errors()->first(),
                "response_code" => 401,
            ], 401);
        }

        $categoryId = $req->categoryId;
        $products = Product::where('categoryId', $categoryId)->get();
        $products = $products->map(function ($product) {
            $images = DB::table('product_images')->where('productId', $product->id)->pluck('image');
            $urlImages = $images->map(function ($img) {
                $img = url('/') . '/' . $img;
                return $img;
            });
            $product->images = $urlImages;

            $reviews = DB::table('reviews')->where('productId', $product->id)->get(['id', 'userId', 'productId', 'rating', 'description']);
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
            $product->reviews = $reviews;
            return $product;
        });
        return response()->json([
            "response_message" => "Ok!",
            "response_code" => 200,
            "data" => $products
        ], 200);
    }
}
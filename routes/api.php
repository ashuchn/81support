
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ProductDetails;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ReviewController;
use App\Mail\sendOtp;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('fcm', [AuthController::class, 'fcm']);
Route::get('test', [AuthController::class, 'test']);

Route::middleware('auth:sanctum')->get('/profile/view', function (Request $request) {
    
     return $request->user();
});

    Route::get('allProducts', [ShopController::class, 'allProducts']);
Route::group(['middleware' => 'auth:sanctum'],function () {
    Route::get('authenticate', [AuthController::class, 'authenticate']);
    Route::apiResource('profile', ProfileController::class);
    Route::post('getNearestShops', [ShopController::class, 'getNearestShops']);
    Route::get('getNotifications', [NotificationController::class, 'getNotifications']);
    Route::get('getCategories', [ShopController::class, 'getCategories']);
    Route::post('addProductToCart', [ShopController::class, 'addProductToCart']);
    Route::delete('removeProductFromCart/{id}', [ShopController::class, 'removeProductFromCart']);
    Route::post('bookmarkProduct', [ShopController::class, 'bookmarkProduct']);
    Route::delete('deleteBookmarkedProduct/{id}',[ShopController::class, 'deleteBookmarkedProduct']);    
    Route::get('getProduct',[ShopController::class,'getProduct']);
    Route::post('ProductDetails',[ProductDetails::class,'ProductDetails']);
    Route::get('getCart',[ShopController::class,'getCart']);
    Route::get('getBookmarks',[ShopController::class,'getBookmarks']);
    Route::post('getDeals',[ShopController::class,'getDeals']);
    Route::post('increaseCartProductCount',[ShopController::class,'increaseCartProductCount']);
    Route::post('decreaseCartProductCount',[ShopController::class,'decreaseCartProductCount']);
    Route::post('getProductsByCategory',[ShopController::class,'getProductsByCategory']);
    
    Route::post('getProfile',[ProfileController::class,'getProfile']);
    Route::post('updateProfile',[ProfileController::class,'updateProfile']);
    Route::post('addAddress',[ProfileController::class,'addAddress']);
    Route::get('getAddress',[ProfileController::class,'getAddress']);
    Route::post('editAddress',[ProfileController::class,'editAddress']);
    Route::post('updateAddress',[ProfileController::class,'updateAddress']);
    Route::get('myreviews', [ReviewController::class, 'getReview']);
});


Route::post('login',[AuthController::class, 'login'])->name('login');

Route::post('signup',[AuthController::class, 'signup'])->name('signup');

Route::post('checkEmailExist', [AuthController::class, 'checkEmailExist'])->name('checkEmailExist');
Route::post('verifyOtp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('changePassword',[AuthController::class, 'changePassword'])->name('changePassword');
// Route::post('sendOtp',[AuthController::class, 'sendOtp'])->name('sendOtp');

// Route::post('verify',[AuthController::class, 'verify'])->name('verify');


/**
 * 
 */
Route::post('gEmail', function(Request $request){
    // return $request->all();
    Mail::to('aashutosh.quantum@gmail.com')->send(new App\Mail\githubActionMail());
    return response()->json(['message'=>'Mail Send Successfully!!']);
});



/**
 * J Mail 
 */
Route::post('jEmail', function(Request $request){
    $name = $request->name;
    $email = $request->email;
    $phone =    $request->phone;
    $messege = $request->messege;

    $data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'messege' => $messege
    );

    Mail::send('emails.jMail', ['data' => $data], function($message) use ($data){
        $message->to($data['email']);
        $message->subject('Your Query has been received');
    });
    
    return response()->json( [
        'response_code' => 200,
        'data' => 'Mail Send Successfully!!',
    ] );
});
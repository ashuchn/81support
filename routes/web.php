<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RidingCharterController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\StaticContentController;
use App\Http\Controllers\Admin\FilterController;



//subadmin controllers

use App\Http\Controllers\subadmin\AuthController;
use App\Http\Controllers\subadmin\ProductsController;
use App\Http\Controllers\subadmin\ReviewController;
use App\Http\Controllers\subadmin\OrderController;
use App\Http\Controllers\subadmin\ProfileController as SubProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('admin.app');
// });

Route::get('/', [AdminController::class,'dashboard'])->name('admin.dashboard');


Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('login/post', [AdminController::class, 'loginPost'])->name('admin.loginPost');
    // admin.logout
    Route::get('logout',[AdminController::class, 'logout'])->name('admin.logout');
    Route::middleware(['checkAdminLogin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('filter', FilterController::class);

        // user profile
        Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

        /**
         * notifications
         */

        Route::get('notification', [NotificationController::class,'index'])->name('admin.notification');
        Route::post('sendNotification', [NotificationController::class,'sendNotification'])->name('admin.sendNotification');
        
        //user
        Route::get('add_user', [UserController::class, 'add_user'])->name('admin.add_user');
        
        Route::post('change-status-user', [UserController::class, 'change_status_user'])->name('change-status-user');
        
        Route::get('view_user/{id}', [UserController::class, 'view_user'])->name('admin.view_user');
        
        Route::post('update_user', [UserController::class, 'update'])->name('admin.update_user');
        
        Route::get('destroy_user/{id}', [UserController::class, 'destroy_user'])->name('admin.destroy_user');
        
        Route::resource('user', UserController::class);
        
        //riding charter
        Route::get('add_ridingcharter', [RidingCharterController::class, 'add_ridingcharter'])->name('admin.add_ridingcharter');
    
        Route::post('change_status_ridingcharter', [RidingCharterController::class, 'change_status_ridingcharter'])->name('change_status_ridingcharter');
        
        Route::get('view_ridingcharter/{id}', [RidingCharterController::class, 'view_ridingcharter'])->name('admin.view_ridingcharter');
        
        Route::post('update_ridingcharter', [RidingCharterController::class, 'update'])->name('admin.update_ridingcharter');
        
        Route::get('destroy_ridingcharter/{id}', [RidingCharterController::class, 'destroy_ridingcharter'])->name('admin.destroy_ridingcharter');
        
        Route::resource('ridingcharter', RidingCharterController::class);
        
         //static content
        Route::get('add_static_content', [StaticContentController::class, 'add_static_content'])->name('admin.add_static_content');
        
        Route::get('view_static_content/{id}', [StaticContentController::class, 'view_static_content'])->name('admin.view_static_content');
        
        Route::post('update_static_content', [StaticContentController::class, 'update'])->name('admin.update_static_content');
        
        Route::get('destroy_static_content/{id}', [StaticContentController::class, 'destroy_static_content'])->name('admin.destroy_static_content');
        
        Route::resource('static_content', StaticContentController::class);
        
    });

});



Route::prefix('subadmin')->group(function(){
    Route::view('login','subadmin.auth.login')->name('subadmin.login');
    Route::post('loginPost', [AuthController::class, 'loginPost'])->name('subadmin.loginPost');
    Route::get('logout',[AuthController::class, 'logout'])->name('subadmin.logout');
    Route::middleware(['checkSubLogin'])->group(function () {
        Route::get('dashboard',[AuthController::class, 'dashboard'])->name('subadmin.dashboard');

        Route::resource('products',ProductsController::class)->names([
            'index' => 'subadmin.products.index',
            'create' => 'subadmin.products.create',
            'store' => 'subadmin.products.store',
            'show' => 'subadmin.products.show',
            'update' => 'subadmin.products.update',
            'destroy' => 'subadmin.products.destroy',
        ]);

        Route::get('profile', [SubProfileController::class, 'index'])->name('subadmin.profile.index');
        Route::post('profileUpdate', [SubProfileController::class, 'update'])->name('subadmin.profile.update');

        Route::get('reviews', [ReviewController::class, 'getReview'])->name('subadmin.reviews');

        Route::get('orders', [OrderController::class, 'getOrder'])->name('subadmin.orders');
    });
});

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
Route::middleware(['maintenance_active'])->group(function () {
    Route::get('maintenance', [HomeController::class, "maintenance"])->name('user.maintenance');
});

Route::middleware(['maintenance'])->group(function () {
    Route::get('/', [HomeController::class, "index"])->name('user.home');
    Route::get('introduction', [HomeController::class, "introduction"])->name('user.introduction');
    Route::get('product-detail/{product}', [ProductDetailController::class, "show"])->name('user.products_detail');
    Route::get('search', [SearchController::class, "search"])->name('user.search');
    Route::get('products/{slug}', [ProductController::class, "index"])->name('user.products');
    
    Route::middleware(['auth.user'])->group(function () {
        Route::get('logout', [AuthenticatedSessionController::class, "destroy"])->name('user.logout');
        Route::post('product-review/{product}', [ProductReviewController::class, "store"])->name('product_review.store');
        Route::group(['prefix' => 'cart'], function(){
            Route::get('/', [CartController::class, 'index'])->name('cart.index');
            Route::post('add-to-cart', [CartController::class, 'store'])->name('cart.store');
            Route::post('update-cart', [CartController::class, 'update'])->name('cart.update');
            Route::get('delete{id}', [CartController::class, 'delete'])->name('cart.delete');
            Route::get('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
        });
    
        Route::group(['prefix' => 'checkout'], function(){
            Route::get('/', [CheckOutController::class, 'index'])->name('checkout.index');
            Route::post('/', [CheckOutController::class, 'store']);
            Route::get('/callback-momo', [CheckOutController::class, 'callbackMomo'])->name('checkout.callback_momo');
            Route::get('/callback-vnpay', [CheckOutController::class, 'callbackVNPay'])->name('checkout.callback_vnpay');
        });
    
        Route::group(['prefix' => 'profile'], function(){
            Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
            Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change_password');
            Route::post('/change-profile', [ProfileController::class, 'changeProfile'])->name('profile.change_profile');
        });
    
        Route::group(['prefix' => 'order-history'], function(){
            Route::get('/', [OrderHistoryController::class, 'index'])->name('order_history.index');
            Route::get('/detail/{order}', [OrderHistoryController::class, 'show'])->name('order_history.show');
            Route::get('/update/{order}', [OrderHistoryController::class, 'update'])->name('order_history.update');
        });
    
    
    });
    
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, "create"])->name('user.login');
        Route::post('login', [AuthenticatedSessionController::class, "store"]);
    
        Route::get('register', [RegisterController::class, "create"])->name('user.register');
        Route::post('register', [RegisterController::class, "store"]);
        Route::get('verify-email/{user}', [RegisterController::class, "verifyEmail"])
            ->name('user.verification.notice');
        Route::get('account/verify/{id}', [VerifyEmailController::class, 'verifyAccount'])
            ->name('user.verify');
        Route::post('resend-email', [RegisterController::class, "resendEmail"])->name('user.resend_email');
        Route::get('verify-success', [RegisterController::class, "success"])->name('user.verify.success');
    
        Route::get('forgot-password', [ForgotPasswordController::class, "create"])->name('user.forgot_password_create');
        Route::post('forgot-password', [ForgotPasswordController::class, "store"])->name('user.forgot_password_store');
        Route::get('account/change-new-password', [ForgotPasswordController::class, "changePassword"])->name('user.change_new_password');
        Route::post('account/change-new-password', [ForgotPasswordController::class, "updatePassword"]);
    
    });
});




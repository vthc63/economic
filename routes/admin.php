<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController as AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth.admin'])->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, "destroy"])->name('admin.logout');
    Route::get('verify-email', [AdminEmailVerificationPromptController::class, "__invoke"])
        ->name('admin.verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('admin.verification.send');
    Route::get('account/verify/{id}', [VerifyEmailController::class, 'verifyAccount'])
        ->name('admin.user.verify');
    Route::get('verify-email/success', [VerifyEmailController::class, 'success'])
        ->name('admin.verify.success');
});

Route::middleware(['auth.admin', 'admin.verified'])->group(function () {
    Route::get('/', [DashboardController::class, "index"])->name('admin.home');

    Route::group(['prefix' => 'users'], function(){
        Route::get('/', [UserController::class, "index"])->name('admin.users_index');
        Route::get('create', [UserController::class, "create"])->name('admin.users_create');
        Route::post('create', [UserController::class, "store"])->name('admin.users_store');
        Route::get('edit/{user}', [UserController::class, "edit"])->name('admin.users_edit');
        Route::post('update/{user}', [UserController::class, "update"])->name('admin.users_update');
        Route::post('delete', [UserController::class, "delete"])->name('admin.users_delete');
    });

    Route::group(['prefix' => 'profile'], function(){
        Route::get('/change-profile', [ProfileController::class, "changeProfile"])->name('admin.profile_change-profile');
        Route::post('/change-profile', [ProfileController::class, "updateProfile"])->name('admin.profile_update-profile');
        Route::get('/change-password', [ProfileController::class, "changePassword"])->name('admin.profile_change-password');
        Route::post('/change-password', [ProfileController::class, "updatePassword"])->name('admin.profile_update-password');
    });

    Route::group(['prefix' => 'products'], function(){
        Route::get('/', [ProductController::class, "index"])->name('admin.product_index');
        Route::get('create', [ProductController::class, "create"])->name('admin.products_create');
        Route::post('create', [ProductController::class, "store"])->name('admin.products_store');
        Route::get('update/{product}', [ProductController::class, "edit"])->name('admin.products_edit');
        Route::post('update/{product}', [ProductController::class, "update"])->name('admin.products_update');
        Route::post('delete', [ProductController::class, "delete"])->name('admin.products_delete');

        Route::get('get-categories-by-parent', [ProductController::class, "getCategoryByParent"])->name('admin.category_by_parent');

        Route::get('color/{product}', [ProductController::class, "createColor"])->name('admin.products_color');
        Route::post('color/{product}', [ProductController::class, "storeColor"])->name('admin.products_color_store');
        Route::get('color-update/{productColor}', [ProductController::class, "editColor"])->name('admin.products_color_edit');
        Route::post('color-update/{productColor}', [ProductController::class, "updateColor"])->name('admin.products_color_update');
        Route::post('color-delete/{productColor}', [ProductController::class, "deleteColor"])->name('admin.products_color_delete');

        Route::get('size/{product}', [ProductController::class, "createSize"])->name('admin.products_size');
        Route::get('size-by-product-color', [ProductController::class, "getSizeByProductColor"])->name('admin.size_by_product_color');
        Route::get('size-by-product-color-edit/{productSize}', [ProductController::class, "getSizeByProductColorEdit"])->name('admin.size_by_product_color_edit');
        Route::post('store-size-product/{product}', [ProductController::class, "storeSizeProduct"])->name('admin.store_size_product');
        Route::post('delete-size-product/{productSize}', [ProductController::class, "deleteSizeProduct"])->name('admin.delete_size_product');
        Route::get('update-size-product/{productSize}/{product}', [ProductController::class, "editSizeProduct"])->name('admin.update_size_product');
        Route::post('update-size-product/{productSize}/{product}', [ProductController::class, "updateSizeProduct"])->name('admin.update_size_product');
        
    });

    Route::group(['prefix' => 'categories'], function(){
        Route::get('/', [CategoryController::class, "index"])->name('admin.category_index');
        Route::get('create', [CategoryController::class, "create"])->name('admin.category_create');
        Route::post('create', [CategoryController::class, "store"])->name('admin.category_store');
        Route::get('edit/{category}', [CategoryController::class, "edit"])->name('admin.category_edit');
        Route::post('update/{category}', [CategoryController::class, "update"])->name('admin.category_update');
        Route::post('delete', [CategoryController::class, "delete"])->name('admin.category_delete');
    });

    Route::group(['prefix' => 'colors'], function(){
        Route::get('/', [ColorController::class, "index"])->name('admin.colors_index');
        Route::get('create', [ColorController::class, "create"])->name('admin.colors_create');
        Route::post('create', [ColorController::class, "store"])->name('admin.colors_store');
        Route::get('edit/{color}', [ColorController::class, "edit"])->name('admin.colors_edit');
        Route::post('update/{color}', [ColorController::class, "update"])->name('admin.colors_update');
        Route::post('delete', [ColorController::class, "delete"])->name('admin.colors_delete');
    });

    Route::group(['prefix' => 'brands'], function(){
        Route::get('/', [BrandController::class, "index"])->name('admin.brands_index');
        Route::get('create', [BrandController::class, "create"])->name('admin.brands_create');
        Route::post('create', [BrandController::class, "store"])->name('admin.brands_store');
        Route::get('edit/{brand}', [BrandController::class, "edit"])->name('admin.brands_edit');
        Route::post('update/{brand}', [BrandController::class, "update"])->name('admin.brands_update');
        Route::post('delete', [BrandController::class, "delete"])->name('admin.brands_delete');
    });

    Route::group(['prefix' => 'orders'], function(){
        Route::get('/', [OrderController::class, "index"])->name('admin.orders_index');
        Route::get('create', [OrderController::class, "create"])->name('admin.orders_create');
        Route::post('create', [OrderController::class, "store"])->name('admin.orders_store');
        Route::get('edit/{order}', [OrderController::class, "edit"])->name('admin.orders_edit');
        Route::post('update/{order}', [OrderController::class, "update"])->name('admin.orders_update');
        Route::post('delete', [OrderController::class, "delete"])->name('admin.orders_delete');
    });

    Route::group(['prefix' => 'sizes'], function(){
        Route::get('/', [SizeController::class, "index"])->name('admin.sizes_index');
        Route::get('create', [SizeController::class, "create"])->name('admin.sizes_create');
        Route::post('create', [SizeController::class, "store"])->name('admin.sizes_store');
        Route::get('edit/{size}', [SizeController::class, "edit"])->name('admin.sizes_edit');
        Route::post('update/{size}', [SizeController::class, "update"])->name('admin.sizes_update');
        Route::post('delete', [SizeController::class, "delete"])->name('admin.sizes_delete');
    });

    Route::middleware('auth.admin_author:admin')->group(function () {

        Route::group(['prefix' => 'setting'], function(){
            Route::get('/', [SettingController::class, "index"])->name('admin.setting_index');
            Route::post('/', [SettingController::class, "store"])->name('admin.setting_index');
        });
        
        Route::group(['prefix' => 'payments'], function(){
            Route::get('/', [PaymentMethodController::class, "index"])->name('admin.payments_index');
            Route::get('create', [PaymentMethodController::class, "create"])->name('admin.payments_create');
            Route::post('create', [PaymentMethodController::class, "store"])->name('admin.payments_store');
            Route::get('edit/{payment}', [PaymentMethodController::class, "edit"])->name('admin.payments_edit');
            Route::post('edit/{payment}', [PaymentMethodController::class, "update"])->name('admin.payments_update');
        });

        Route::group(['prefix' => 'staffs'], function(){
            Route::get('/', [AdminController::class, "index"])->name('admin.staffs_index');
            Route::get('create', [AdminController::class, "create"])->name('admin.staffs_create');
            Route::post('create', [AdminController::class, "store"])->name('admin.staffs_store');
            Route::get('edit/{user}', [AdminController::class, "edit"])->name('admin.staffs_edit');
            Route::post('edit/{user}', [AdminController::class, "update"])->name('admin.staffs_update');
            Route::post('delete', [AdminController::class, "delete"])->name('admin.staffs_delete');
        });

    });
});

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, "create"])->name('admin.login');
    Route::post('login', [AuthenticatedSessionController::class, "store"]);
});
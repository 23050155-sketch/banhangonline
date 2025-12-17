<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController as PublicProductController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Products (PUBLIC – khách hàng)
|--------------------------------------------------------------------------
*/
Route::get('/products/{product}', [PublicProductController::class, 'show'])
    ->name('products.show');

/*
|--------------------------------------------------------------------------
| Reviews (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/cap-nhat/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/xoa/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/gio-hang/xoa-het', [CartController::class, 'clear'])->name('cart.clear');

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/
Route::get('/thanh-toan', [CheckoutController::class, 'form'])->name('checkout.form');
Route::post('/thanh-toan', [CheckoutController::class, 'place'])->name('checkout.place');
Route::get('/dat-hang-thanh-cong/{order}', [CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])
    ->name('checkout.coupon.apply');
Route::delete('/checkout/coupon', [CheckoutController::class, 'removeCoupon'])
    ->name('checkout.coupon.remove');

/*
|--------------------------------------------------------------------------
| ADMIN (quản trị)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin')
    ->group(function () {

        // Categories
        Route::resource('categories', CategoryController::class);

        // Products (ADMIN)
        Route::resource('products', AdminProductController::class);

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.status');

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggleStatus');

        // Coupons
        Route::resource('coupons', CouponController::class);
        Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])
            ->name('coupons.toggle');

        // Reviews moderation
        Route::get('reviews', [ReviewAdminController::class, 'index'])
            ->name('reviews.index');
        Route::patch('reviews/{review}/toggle', [ReviewAdminController::class, 'toggle'])
            ->name('reviews.toggle');
        Route::delete('reviews/{review}', [ReviewAdminController::class, 'destroy'])
            ->name('reviews.destroy');
    });




    Route::get('/test-layout', function () {
        return view('test');
    });


    Route::get('/trangchu', function () {
        return view('home');
    })->name('home');


    Route::get('/lien-he', function () {
        return view('public.contact');
    })->name('contact');



    Route::get('/phones',  [PublicController::class, 'phones'])->name('phones.page');
    Route::get('/laptops', [PublicController::class, 'laptops'])->name('laptops.page');
    Route::get('/clothes', [PublicController::class, 'clothes'])->name('clothes.page');
    Route::get('/cars',    [PublicController::class, 'cars'])->name('cars.page');







    

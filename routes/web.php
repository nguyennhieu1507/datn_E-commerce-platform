<?php

use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\user\homeController;
use App\Http\Controllers\user\orderController;
use App\Http\Controllers\user\paymentController;
use App\Http\Controllers\user\productController;
use App\Http\Controllers\user\storeController;
use App\Http\Controllers\user\userController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Web Router for user
|--------------------------------------------------------------------------
*/

Route::prefix('/')->group(function () {

    Route::get('/', [homeController::class, 'home'])->name('user.home');
    Route::get('/product/{slug}', [productController::class, 'detail'])->name('user.productDetail');
    Route::get('/page-search', [homeController::class, 'pageSearch'])->name('user.pageSearch');

    Route::prefix('/')->middleware('auth')->group(function () {
        // cart
        Route::get('/your-cart', [userController::class, 'cart'])->name('user.cart');
        Route::get('/checkout', [orderController::class, 'checkout'])->name('user.checkout');
        Route::post('/store-cart', [userController::class, 'store_cart'])->name('user.store_cart');
        Route::post('/delete-item-cart', [userController::class, 'delete_item_cart'])->name('user.delete_item_cart');
        Route::post('/update-item-cart', [userController::class, 'update_item_cart'])->name('user.update_item_cart');
        Route::post('/choose-cart', [orderController::class, 'chooseCart'])->name('user.chooseCart');
        Route::post('/checkout-store', [paymentController::class, 'checkout'])->name('user.checkout-store');
        Route::get('/pay-return', [paymentController::class, 'pay_return'])->name('user.pay-return');
        Route::get('/checkout-return/{order}', [paymentController::class, 'checkout_return'])->name('user.checkout-return');
        Route::post('/get-voucher', [storeController::class, 'get_voucher'])->name('user.get_voucher');
        
        // store
        Route::get('/store/10000000000{id}', [storeController::class, 'store'])->name('user.store');
        Route::get('/voucher-store/10000000000{id}', [storeController::class, 'voucher_store'])->name('user.voucher_store');
        Route::POST('/check-code', [storeController::class, 'check_code'])->name('user.check_code');
        Route::POST('/add-voucher/10000000000{id}', [storeController::class, 'add_voucher'])->name('user.add_voucher');
        Route::POST('/delete-voucher/10000000000{id}', [storeController::class, 'delete_voucher'])->name('user.delete_voucher');
        Route::POST('/update-voucher/10000000000{id}', [storeController::class, 'update_voucher'])->name('user.update_voucher');

        // add product into store
        Route::get('/create-product-store/{id}', [storeController::class, 'createProduct'])->name('user.create-product-store');
        Route::post('/create-product-store/{id}', [storeController::class, 'storeAddProduct'])->name('user.add-product-store');

        // profile
        Route::get('/profile', [userController::class, 'profile'])->name('user.profile');
        Route::post('/profile', [userController::class, 'updateProfile'])->name('user.update_profile');

        // user address
        Route::get("/address-user", [userController::class, 'userAddress'])->name('user.address');
        Route::post("/address-user", [userController::class, 'addUserAddress'])->name('user.add_address');
        Route::get("/edit-user/{id}", [userController::class, 'showUserAddress'])->name('user.show_address');
        Route::put("/update-address-user/{id}", [userController::class, 'updateUserAddress'])->name('user.update_address');
        Route::delete("/delete-address-user/{id}", [userController::class, 'deleteUserAddress'])->name('user.delete_address');
        Route::put("/update-status-address/{id}", [userController::class, 'updateAddressStatus'])->name('user.update_status_address');

        // register booth
        Route::get("/register-booth", [userController::class, 'register_booth'])->name("user.register_booth");
        Route::post("/register-booth", [userController::class, 'store_booth'])->name("user.store_booth");

        // order
        Route::get('/manage-order', [orderController::class, 'manageOrder'])->name('user.manage-order');
        Route::get('/order-detail/{slug}', [orderController::class, 'orderDetail']);

    });
});

/*
|--------------------------------------------------------------------------
| Web Router for admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::prefix('/')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [dashboardController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/category', [dashboardController::class, 'category'])->name('admin.category');
        
        Route::get('/voucher-manager', [dashboardController::class, 'voucher'])->name('admin.voucher');
        Route::post('/voucher-manager', [dashboardController::class, 'add_voucher'])->name('admin.add_voucher');
        Route::get('/update-voucher/{voucher}/{status}', [dashboardController::class, 'update_voucher'])->name('admin.update_voucher');
    
        Route::get('/member', [dashboardController::class, 'member'])->name('admin.member');
        Route::get('/update-member/{member}/{status}', [dashboardController::class, 'update_member'])->name('admin.update_member');

        Route::get('/store', [dashboardController::class, 'store'])->name('admin.store');
        Route::get('/update-store/{store}/{status}', [dashboardController::class, 'update_store'])->name('admin.update_store');
        Route::get('/update-ticket-store/{ticket}/{status}', [dashboardController::class, 'update_ticket_store'])->name('admin.update_ticket_store');
    }); 
});

require __DIR__ . '/auth.php';

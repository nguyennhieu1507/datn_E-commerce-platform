<?php

use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\user\homeController;
use App\Http\Controllers\user\productController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Router for user
|--------------------------------------------------------------------------
*/

Route::prefix('/')->group(function () {
    Route::get('/',[homeController::class, 'home'])->name('user.home');
    Route::get('/checkout',[homeController::class, 'checkout'])->name('user.checkout');
    Route::get('/product/{slug}', [productController:: class, 'detail'])->name('user.productDetail');
    Route::get('/auth',[homeController::class, 'auth'])->name('user.auth');
});

/*
|--------------------------------------------------------------------------
| Web Router for admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/',[dashboardController::class, 'dashboard'])->name('admin.dashboard');
});
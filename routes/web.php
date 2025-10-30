<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/car_detail', function () {
    return view('car/911');
});

Route::get('/order_911', [CarController::class, 'orderPage'])->name('order.911');


Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'registerPage'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::get('/car_detail', function () {
    return view('car/911');
});
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/configure/{id}', [CheckoutController::class, 'configure'])->name('configure');

Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/biodata/{id}', [CheckoutController::class, 'biodata'])->name('checkout.biodata');
Route::post('/checkout/biodata/save', [CheckoutController::class, 'saveBiodata'])->name('checkout.biodata.save');
Route::get('/checkout/payment/{id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
Route::get('/checkout/{mobil_id}', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/midtrans/callback', [CheckoutController::class, 'callback']);
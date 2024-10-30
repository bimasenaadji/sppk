<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('loginForm');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/change_pass', 'change_pass')->name('change_pass');
});



Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index')->name('customer.index');
    Route::get('/customer/data', 'data')->name('customer.data');
    Route::get('/customer/{customer}', 'edit')->name('customer.edit');
    Route::delete('/customer/{customer}', 'destroy')->name('customer.destroy');
    Route::post('/customer', 'store')->name('customer.store');
    Route::put('/customer/{customer}', 'update')->name('customer.update');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/data', 'data')->name('user.data');
    Route::get('/user/{user}', 'edit')->name('user.edit');
    Route::delete('/user/{user}', 'destroy')->name('user.destroy');
    Route::post('/user', 'store')->name('user.store');
    Route::put('/user/{user}', 'update')->name('user.update');
});



Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('dashboard');
});

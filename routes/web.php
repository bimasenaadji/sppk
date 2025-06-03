<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportChartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaxCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Order;
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

// Route default langsung ke halaman login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.redirect');


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('loginForm');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/change_pass', 'change_pass')->name('change_pass');
    Route::get('/register', 'showRegisterForm')->name('registerForm');
    Route::post('/register', 'register')->name('register');

});



Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/data', 'data')->name('user.data');
    Route::get('/user/{id}', 'edit')->name('user.edit');
    Route::delete('/user/{id}', 'destroy')->name('user.destroy');
    Route::post('/user', 'store')->name('user.store');
    Route::put('/user/{id}', 'update')->name('user.update');
});


Route::prefix('report')->controller(ReportController::class)->group(function () {
    Route::get('/', 'index')->name('report.index');
    Route::get('/data', 'getData')->name('report.data');
    Route::post('/', 'store')->name('report.store');
    Route::get('/{id}/edit', 'edit')->name('report.edit');
    Route::put('/{id}/update', 'update')->name('report.update');
    Route::post('/{id}/confirm', 'confirmOrder')->name('report.confirm');
    Route::put('/{report}/success', 'successOrder')->name('report.success');
    Route::post('/{id}/cancel', 'cancel')->name('report.cancel');
    Route::get('/{report}/invoice', 'showInvoice')->name('report.invoice');
    Route::get('/{report}/print', 'printInvoice')->name('report.print');
    Route::delete('/{id}/delete', 'destroy')->name('report.delete');
    
});

Route::prefix('inspect')->name('inspect.')->group(function () {
    Route::get('/', [InspectionController::class, 'index'])->name('index');
    Route::get('/data', [InspectionController::class,'data'])->name('data');
    Route::post('/', [InspectionController::class, 'store'])->name('store');
    Route::post('/{id}/finish', [InspectionController::class, 'finish'])->name('finish');
    Route::get('/{id}/invoice', [InspectionController::class, 'generateInvoice'])->name('invoice');
    Route::delete('/{id}/delete', [InspectionController::class,'delete'])->name('delete');
});

Route::get('/report-chart', [ReportChartController::class, 'index'])->name('report.chart');

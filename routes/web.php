<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
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

Route::get('admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::post('admin/admin_login', [LoginController::class, 'adminlogin'])->name('admin.adminlogin');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dshboard');
        Route::prefix('customer')->controller(CustomerController::class)->group(function () {
            Route::get('/', 'index')->name('customer.index');
            Route::post('/store', 'store')->name('customer.store');
            Route::post('/status/{id}', 'status')->name('customer.status');
            Route::get('/edit/{id}', 'edit')->name('customer.edit');
            Route::post('/update/{id}', 'update')->name('customer.update');
            Route::get('/destroy/{id}', 'destroy')->name('customer.delete');
        });
    });
});

Route::get('/', function () {
    return view('auth.login');
});

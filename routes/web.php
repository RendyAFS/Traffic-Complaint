<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route untuk Admin
Route::middleware(['auth', 'checklevel:Admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/upload-complaint-admin', [AdminController::class, 'formComplaint'])->name('form-complaint-admin');
    Route::get('/admin/complaints/data', [AdminController::class, 'getDataComplaint'])->name('getDataComplaint');
});

// Route untuk User
Route::middleware(['auth', 'checklevel:User'])->group(function () {
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::post('/upload-complaint-user', [UserController::class, 'formComplaint'])->name('form-complaint-user');
    Route::get('/user/complaints/data', [UserController::class, 'getDataRiwayat'])->name('getDataRiwayat');
});

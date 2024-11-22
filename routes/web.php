<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use App\Models\Complient;
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

Route::get('/', [LandingPageController::class, 'indexLandingPage'])->name('indexLandingPage');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route untuk Admin
Route::middleware(['auth', 'checklevel:Admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/all-complaints/data', [AdminController::class, 'getDataAllComplaint'])->name('getDataAllComplaint');
    Route::post('/upload-complaint-admin', [AdminController::class, 'formComplaint'])->name('form.complaint.admin');
    Route::post('/update-status', [AdminController::class, 'updateStatus'])->name('update.status');


    Route::get('/admin/new-complaint', [AdminController::class, 'indexNewComplaint'])->name('admin.new.complaint');
    Route::get('/admin/new-complaints/data', [AdminController::class, 'getDataNewComplaint'])->name('getDataNewComplaint');

    Route::post('/upload-file-aduan-admin', [AdminController::class, 'uploadFileAduan'])->name('upload.fileAduan.admin');

    Route::get('/admin/process-complaint', [AdminController::class, 'indexProcessComplaint'])->name('admin.process.complaint');
    Route::get('/admin/process-complaints/data', [AdminController::class, 'getDataProcessComplaint'])->name('getDataProcessComplaint');

    Route::get('/admin/done-complaint', [AdminController::class, 'indexDoneComplaint'])->name('admin.done.complaint');
    Route::get('/admin/done-complaints/data', [AdminController::class, 'getDataDoneComplaint'])->name('getDataDoneComplaint');
});

// Route untuk User
Route::middleware(['auth', 'checklevel:User'])->group(function () {
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::post('/upload-complaint-user', [UserController::class, 'formComplaint'])->name('form.complaint.user');
    Route::get('/user/complaints/data', [UserController::class, 'getDataRiwayat'])->name('getDataRiwayat');
});

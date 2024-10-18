<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\StudentController;
use \App\Http\Controllers\PaymentController;
use \App\Http\Controllers\TrackRecordController;
use \App\Http\Controllers\UserController;

Route::get('/scan', [AuthController::class, 'landing'])->name('landing');
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


//Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/edit/{transaction}', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/update/{transaction}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/destroy', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('students/view/{transaction}', [StudentController::class, 'view'])->name('students.view');

    Route::get('records', [TrackRecordController::class, 'index'])->name('records.index');
    Route::get('records/create', [TrackRecordController::class, 'create'])->name('records.create');
    Route::post('records/store', [TrackRecordController::class, 'store'])->name('records.store');
    Route::get('records/edit/{transaction}', [TrackRecordController::class, 'edit'])->name('records.edit');
    Route::put('records/update/{transaction}', [TrackRecordController::class, 'update'])->name('records.update');
    Route::delete('records/destroy', [TrackRecordController::class, 'destroy'])->name('records.destroy');
    Route::get('records/view/{transaction}', [TrackRecordController::class, 'view'])->name('records.view');

    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/edit/{transaction}', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('payments/update/{transaction}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('payments/destroy', [PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('payments/view/{transaction}', [PaymentController::class, 'view'])->name('payments.view');
    Route::get('payments/{id}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/email/check', [UserController::class, 'emailcheck'])->name('users.emailcheck');
    Route::get('users/{id}/pdf', [UserController::class, 'pdf'])->name('users.pdf');

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');
    Route::put('/profile', [AuthController::class, 'update'])->name('password.update');
//});
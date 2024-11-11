<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministrationController;

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
    // Redirect to login if user is not logged in
    return redirect()->route('auth.login');
});


// login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login')->middleware('guest');
Route::post('login', [AuthController::class, 'login_process'])->name('auth.login_process');

// register
route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
route::post('register', [AuthController::class, 'registration_process'])->name('auth.registration_process');

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// after success login go to manage-account
route::get('manage-account', [AdministrationController::class, 'manage_account'])->name('administration.manage_account')->middleware('auth');
route::post('manage-account-profile', [AdministrationController::class, 'manage_account_profile'])->name('administration.manage_account_profile')->middleware('auth');
route::post('manage-account-password', [AdministrationController::class, 'manage_account_password'])->name('administration.manage_account_password')->middleware('auth');

// pengurusan pengguna
route::get('pengurusan-pengguna', [AdministrationController::class, 'pengurusan_pengguna_list'])->name('administration.pengurusan_pengguna')->middleware('auth');




<?php

use App\Models\Pengguna;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Spatie\Permission\Models\Permission;
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
// Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login')->middleware('can:log masuk portal');
Route::post('login', [AuthController::class, 'login_process'])->name('auth.login_process');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login')->middleware('guest');

// register
route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register')->middleware('can:daftar sebagai pengguna');
route::post('register', [AuthController::class, 'registration_process'])->name('auth.registration_process');

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// after success login go to manage-account
route::get('manage-account', [AdministrationController::class, 'manage_account'])->name('administration.manage_account');
route::post('manage-account-profile', [AdministrationController::class, 'manage_account_profile'])->name('administration.manage_account_profile');
route::post('manage-account-password', [AdministrationController::class, 'manage_account_password'])->name('administration.manage_account_password');

// pengurusan pengguna
route::get('pengurusan-pengguna', [AdministrationController::class, 'pengurusan_pengguna_list'])->name('administration.pengurusan_pengguna')->middleware('can:Melihat Senarai Pengguna');
route::get('tambah-pengguna', [AdministrationController::class, 'tambah_pengguna_list'])->name('administration.tambah_pengguna');
route::post('tambah-pengguna-process', [AdministrationController::class, 'tambah_pengguna_process'])->name('administration.tambah_pengguna_process');
route::get('edit-pengguna/{id}', [AdministrationController::class, 'edit_pengguna'])->name('administration.edit_pengguna');
Route::put('update-pengguna/{id}', [AdministrationController::class, 'update_pengguna'])->name('administration.update_pengguna');


route::get('give-permission-to-role', function () {

    $role = Role::findOrFail(12); //ICT
    
    $permission = Permission::findOrFail(1);
    $permission1 = Permission::findOrFail(2);
    $permission2 = Permission::findOrFail(3);
    $permission3 = Permission::findOrFail(4);
    // $permission4 = Permission::findOrFail(5);
    // $permission5 = Permission::findOrFail(6);
    // $permission6 = Permission::findOrFail(7);
    // $permission7 = Permission::findOrFail(8);
    // $permission8 = Permission::findOrFail(9);
    $permission9 = Permission::findOrFail(10);
    $permission10 = Permission::findOrFail(11);
    $permission11 = Permission::findOrFail(12);

    $role->givePermissionTo([$permission, $permission1, $permission2, $permission3, $permission9, $permission10, $permission11]);
});

Route::get('assign-role-to-user', function() {
     
    $user = Pengguna::findOrFail(8);

    $role = Role::findOrFail(13); 


    $user->assignRole($role);

});


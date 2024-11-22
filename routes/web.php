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
route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
route::post('register', [AuthController::class, 'registration_process'])->name('auth.registration_process');

// reset password
Route::get('forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');

// after click reset password link in email
Route::get('reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// after success login go to manage-account
route::get('manage-account', [AdministrationController::class, 'manage_account'])->name('administration.manage_account')->middleware('auth');
route::post('manage-account-profile', [AdministrationController::class, 'manage_account_profile'])->name('administration.manage_account_profile');
route::post('manage-account-password', [AdministrationController::class, 'manage_account_password'])->name('administration.manage_account_password');

// pengurusan pengguna
route::get('pengurusan-pengguna', [AdministrationController::class, 'pengurusan_pengguna_main'])->name('administration.pengurusan_pengguna_main');
route::get('pengurusan-pengguna-list', [AdministrationController::class, 'pengurusan_pengguna_list'])->name('administration.pengurusan_pengguna');
route::get('tambah-pengguna', [AdministrationController::class, 'tambah_pengguna_list'])->name('administration.tambah_pengguna');
route::post('tambah-pengguna-process', [AdministrationController::class, 'tambah_pengguna_process'])->name('administration.tambah_pengguna_process');

route::get('pengguna-approval/{id}', [AdministrationController::class, 'pengguna_approval_list'])->name('administration.pengguna_approval');
route::put('pengguna-approval-process/{id}', [AdministrationController::class, 'pengguna_approval_process'])->name('administration.pengguna_approval_process');
Route::delete('pengguna_reject/{id}', [AdministrationController::class, 'pengguna_reject_process'])->name('administration.pengguna_reject_process');


route::get('edit-pengguna/{id}', [AdministrationController::class, 'edit_pengguna'])->name('administration.edit_pengguna');
Route::put('update-pengguna/{id}', [AdministrationController::class, 'update_pengguna'])->name('administration.update_pengguna');
Route::put('update-pengguna-password/{id}', [AdministrationController::class, 'update_pengguna_password'])->name('administration.update_pengguna_password');
Route::delete('delete-pengguna/{id}', [AdministrationController::class, 'delete_pengguna'])->name('administration.delete_pengguna');

route::get('senarai-peranan', [AdministrationController::class, 'senarai_peranan'])->name('administration.senarai_peranan');
route::get('kemaskini-peranan/{id}', [AdministrationController::class, 'kemaskini_peranan'])->name('administration.kemaskini_peranan');

// pengurusan data
route::get('pengurusan-data', [AdministrationController::class, 'pengurusan_data_main'])->name('administration.pengurusan_pengguna_data');

//dashboard
route::get('dashboard', [AdministrationController::class, 'dashboard_main'])->name('administration.dashboard');



route::get('reset-password-try', function () {
    return view('auth.reset-password_backup');
});

route::get('give-permission-to-role', function () {

    $role = Role::findOrFail(10); //R
    
    $permission = Permission::findOrFail(13);
    $permission1 = Permission::findOrFail(16);
    $permission2 = Permission::findOrFail(20);
    $permission3 = Permission::findOrFail(23);
    $permission4 = Permission::findOrFail(24);
    $permission5 = Permission::findOrFail(25);
    $permission6 = Permission::findOrFail(25);
    $permission7 = Permission::findOrFail(25);
    $permission8 = Permission::findOrFail(22);
    $permission9 = Permission::findOrFail(23);
    $permission10 = Permission::findOrFail(24);
    $permission11 = Permission::findOrFail(25);
    $permission12 = Permission::findOrFail(24);
    $permission13 = Permission::findOrFail(25);

    // $role->givePermissionTo($permission);
    // $role->givePermissionTo([$permission, $permission1, $permission2, $permission3, $permission4, $permission5, $permission6, $permission7, $permission8, $permission9, $permission10, $permission11]);
    $role->givePermissionTo([$permission, $permission1, $permission2, $permission3, $permission4, $permission5]);
});

Route::get('assign-role-to-user', function() {
     
    $user = Pengguna::findOrFail(9);

    $role = Role::findOrFail(1); 


    $user->assignRole($role);

});

Route::get('remove-permission-from-role', function () {
    $role = Role::findOrFail(2); // Find the role by ID (e.g., ID 2)
    $permission = Permission::findOrFail(6); // Find the specific permission by ID (e.g., ID 6)

    // Revoke the specific permission from the role
    $role->revokePermissionTo($permission);

    return "Permission '{$permission->name}' has been revoked from role '{$role->name}'.";
});

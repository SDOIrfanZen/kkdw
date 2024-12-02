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
Route::get('get-roles-by-bahagian/{bahagian_id}', [AuthController::class, 'getRolesByBahagian']);

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
route::get('manage-account', [AdministrationController::class, 'manage_account'])->name('administration.manage_account')->middleware(['auth', 'can.any:Papar Maklumat Profil Pengguna']);;
route::post('manage-account-profile', [AdministrationController::class, 'manage_account_profile'])->name('administration.manage_account_profile');
route::post('manage-account-password', [AdministrationController::class, 'manage_account_password'])->name('administration.manage_account_password');

// pengurusan pengguna
route::get('pengurusan-pengguna', [AdministrationController::class, 'pengurusan_pengguna_main'])->name('administration.pengurusan_pengguna_main')->middleware('can.any:Melihat Senarai Pengguna|Melihat Senarai Peranan');
route::get('pengurusan-pengguna-list', [AdministrationController::class, 'pengurusan_pengguna_list'])->name('administration.pengurusan_pengguna')->middleware('can.any:Melihat Senarai Pengguna|Melihat Senarai Peranan');
route::get('tambah-pengguna', [AdministrationController::class, 'tambah_pengguna_list'])->name('administration.tambah_pengguna');
route::post('tambah-pengguna-process', [AdministrationController::class, 'tambah_pengguna_process'])->name('administration.tambah_pengguna_process');

route::get('pengguna-approval/{id}', [AdministrationController::class, 'pengguna_approval_list'])->name('administration.pengguna_approval')->middleware('can.any:Meluluskan Permohonan Baru Pengguna');
route::put('pengguna-approval-process/{id}', [AdministrationController::class, 'pengguna_approval_process'])->name('administration.pengguna_approval_process');
Route::delete('pengguna_reject/{id}', [AdministrationController::class, 'pengguna_reject_process'])->name('administration.pengguna_reject_process');


route::get('edit-pengguna/{id}', [AdministrationController::class, 'edit_pengguna'])->name('administration.edit_pengguna')->middleware('can.any:Mengemaskini Maklumat Pengguna');
Route::put('update-pengguna/{id}', [AdministrationController::class, 'update_pengguna'])->name('administration.update_pengguna');
Route::put('update-pengguna-password/{id}', [AdministrationController::class, 'update_pengguna_password'])->name('administration.update_pengguna_password');
Route::put('update-pengguna-peranan/{id}', [AdministrationController::class, 'update_pengguna_peranan'])->name('administration.update_pengguna_peranan');
Route::delete('delete-pengguna/{id}', [AdministrationController::class, 'delete_pengguna'])->name('administration.delete_pengguna');

route::get('senarai-peranan', [AdministrationController::class, 'senarai_peranan'])->name('administration.senarai_peranan')->middleware('can.any:Melihat Senarai Peranan');
route::get('kemaskini-peranan/{id}', [AdministrationController::class, 'kemaskini_peranan'])->name('administration.kemaskini_peranan')->middleware('can.any:Mengemaskini Peranan');
Route::put('kemaskini-peranan/{id}', [AdministrationController::class, 'update_peranan'])->name('administration.update_peranan');

// pengurusan data
route::get('pengurusan-data', [AdministrationController::class, 'pengurusan_data_main'])->name('administration.pengurusan_pengguna_data')->middleware('can.any:Muat Naik Data|Purata Nasional|Unjuran');

//dashboard
route::get('dashboard', [AdministrationController::class, 'dashboard_main'])->name('administration.dashboard')->middleware('can.any:Prestasi Perbelanjaan Negeri|Dashboard Infrastruktur Asas & Laporan|Dashboard Ekonomi & Laporan|Dashboard Modal Insan & Laporan|Dashboard Usahawan|Dashboard Profil Kampung');

//audit
route::get('audit-trail', [AdministrationController::class, 'audit_trail_main'])->name('administration.audit_trail');
route::get('audit-trail-list', [AdministrationController::class, 'audit_trail_list'])->name('administration.audit_trail_list');

route::get('reset-password-try', function () {
    return view('auth.reset-password_backup');
});

Route::get('give-permission-to-role', function () {
    $role = Role::findOrFail(1); // Find the role
    
    // Fetch permissions with IDs from 1 to 41
    $permissions = Permission::whereIn('id', range(1, 41))->get();
    
    // Assign permissions to the role
    $role->givePermissionTo($permissions);

    return 'Permissions successfully assigned to the role!';
});

Route::get('assign-role-to-user', function() {
     
    $user = Pengguna::findOrFail(6);

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


Route::post('assign-roles/{userId}', [AdministrationController::class, 'assignRoles'])->name('assign-roles');

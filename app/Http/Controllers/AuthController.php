<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Agensi;
use App\Mail\UserRegistrationMail;
use App\Mail\AdminUserRegistrationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login_process(Request $request)
    {
        $rules = [
            'kad_pengenalan' => 'required|string|max:255',
            'kata_laluan' => 'required|string|max:255',
        ];

        // Validate the request with dynamic rules
        $validatedData = $request->validate($rules, [
            'kad_pengenalan.required' => 'Kad Pengenalan diperlukan.',
            'kata_laluan.required' => 'Kata Laluan diperlukan.',
        ]);

        // Retrieve all users and decrypt kad_pengenalan for comparison
        $users = Pengguna::all();
        $user = $users->first(function ($user) use ($validatedData) {
            try {
                return Crypt::decryptString($user->kad_pengenalan) === $validatedData['kad_pengenalan'];
            } catch (\Exception $e) {
                return false; // Skip invalid decryption
            }
        });

        if (!$user) {
            // Kad Pengenalan does not exist
            return back()->with('faillogin', 'Kad Pengenalan tidak wujud.');
        }

        if (!Hash::check($validatedData['kata_laluan'], $user->kata_laluan)) {
            // Kata Laluan is incorrect
            return back()->with('faillogin', 'Kata Laluan tidak sah.');
        }

        if ($user->status === '0') {
            // Status is "0", indicating the account is pending approval
            return back()->with('faillogin', 'Akaun anda belum diluluskan oleh pentadbir. Sila tunggu sehingga akaun anda disahkan.');
        }

        if ($user->status !== '1') {
            // Status is not "1", so login is not allowed
            return back()->with('faillogin', 'Akaun anda tidak aktif. Sila hubungi pentadbir.');
        }

        // Log the user in if status is 1
        Auth::login($user);

        // Redirect or return response
        return redirect()->intended(route('administration.manage_account'));
    }

    public function forgotPassword(Request $request)
    {
        // Validate the input fields
        $request->validate(
            [
                'email' => 'required|email',
                'kad_pengenalan' => 'required|string',
            ],
            [
                'email.required' => 'Emel diperlukan.',
                'email.email' => 'Sila masukkan emel yang sah.',
                'kad_pengenalan.required' => 'Kad Pengenalan diperlukan.',
                'kad_pengenalan.string' => 'Kad Pengenalan mesti dalam format teks.',
            ],
        );

        // Retrieve user by email
        $user = Pengguna::where('email', $request->input('email'))->first();

        // Check if the user exists
        if ($user) {
            // Check if the kad_pengenalan matches the stored one for the same user
            if (Crypt::decryptString($user->kad_pengenalan) === $request->input('kad_pengenalan')) {
                // Send the reset link to the user's email
                $status = Password::sendResetLink($request->only('email'));

                // Check if the status is successful or not
                if ($status === Password::RESET_LINK_SENT) {
                    return back()->with(['status' => 'Pautan tetapan semula kata laluan telah dihantar ke emel anda!']);
                } else {
                    return back()->withErrors(['email' => 'Kami tidak dapat menghantar pautan tetapan semula kata laluan. Sila cuba lagi.']);
                }
            } else {
                return back()->withErrors(['email' => 'Kad Pengenalan tidak sepadan dengan emel untuk pengguna ini.']);
            }
        } else {
            return back()->withErrors(['email' => 'Email tidak wujud.']);
        }
    }

    public function resetPassword(Request $request)
    {
        // Validate incoming request
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => [
                    'required',
                    'min:8',
                    'max:12',
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[0-9]/', // At least one number
                    'regex:/[\W_]/', // At least one symbol (non-word character or special character)
                    function ($attribute, $value, $fail) use ($request) {
                        // Custom validation to ensure password does not exactly match Kad Pengenalan
                        $pengguna = Pengguna::where('email', $request->email)->first(); // Get user by email

                        // Check if the password matches Kad Pengenalan
                        if ($pengguna && $value === $pengguna->kad_pengenalan) {
                            $fail('Kata laluan tidak boleh sama dengan Kad Pengenalan.');
                        }
                    },
                ],
                'password_confirmation' => 'required|same:password', // Ensure confirmation matches new password
            ],
            [
                'password.required' => 'Sila masukkan kata laluan baharu untuk kemas kini.',
                'password.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
                'password.max' => 'Kata laluan baharu tidak boleh melebihi 12 aksara.',
                'password.regex' => 'Kata laluan baharu mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor, dan satu simbol.',
                'password_confirmation.required' => 'Sila masukkan kata laluan pengesahan.',
                'password_confirmation.same' => 'Kata laluan baharu dan kata laluan pengesahan tidak sepadan.',
            ],
        );

        // Custom logic for password reset
        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (Pengguna $pengguna, string $password) {
            // Use 'kata_laluan' column instead of 'password'
            $pengguna
                ->forceFill([
                    'kata_laluan' => Hash::make($password),
                ])
                ->setRememberToken(Str::random(60));

            $pengguna->save();

            // Fire password reset event
            event(new PasswordReset($pengguna));
        });

        // Return response based on the password reset status
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.login')->with('status', 'Kata laluan anda telah berjaya ditetapkan semula!');
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }

    public function showRegisterForm()
    {
        $bahagian = Agensi::get();
        $roles = Role::all();

        return view('auth.register', compact('bahagian', 'roles'));
    }

    public function registration_process(Request $request)
    {
        // Validate the request data and assign it to $validated
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'kad_pengenalan' => 'required|string|max:20|unique:pengguna',
                'bahagian_id' => 'required|string|max:255',
                'role' => 'required|exists:roles,name',
                'jawatan' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:pengguna',
                'no_tel' => 'required|string|max:15',
                'kata_laluan' => [
                    'required',
                    'string',
                    'min:8',
                    'max:12',
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/\d/', // At least one digit
                    'regex:/[@$!%*?&]/', // At least one special character
                    'different:kad_pengenalan', // Password must not be the same as Kad Pengenalan
                ],
            ],
            [
                // Custom validation messages
                'nama.required' => 'Nama penuh perlu dilengkapkan.',
                'nama.string' => 'Nama must be a valid string.',
                'kad_pengenalan.required' => 'Nombor Kad Pengenalan perlu dilengkapkan.',
                'kad_pengenalan.string' => 'Kad Pengenalan must be a valid string.',
                'kad_pengenalan.max' => 'Kad Pengenalan tidak boleh melebihi 20 aksara.',
                'kad_pengenalan.unique' => 'Nombor Kad Pengenalan telah wujud dalam rekod sistem.',
                'bahagian_id.required' => 'Bahagian perlu dilengkapkan.',
                'bahagian_id.string' => 'Bahagian must be a valid string.',
                'bahagian_id.max' => 'Bahagian cannot exceed 255 characters.',
                'role.required' => 'Peranan diperlukan.',
                'role.exists' => 'Peranan yang dipilih tidak sah.',
                'jawatan.required' => 'Jawatan perlu dilengkapkan.',
                'jawatan.string' => 'Jawatan must be a valid string.',
                'jawatan.max' => 'Jawatan cannot exceed 255 characters.',
                'email.required' => 'Email perlu dilengkapkan.',
                'email.string' => 'email must be a valid string.',
                'email.email' => 'email must be a valid email address.',
                'email.max' => 'email cannot exceed 255 characters.',
                'email.unique' => 'email telah wujud.',
                'no_tel.required' => 'Nombor Telefon perlu dilengkapkan.',
                'no_tel.string' => 'No Tel must be a valid string.',
                'no_tel.max' => 'No Tel cannot exceed 15 characters.',
                'kata_laluan.required' => 'Kata Laluan perlu dilengkapkan.',
                'kata_laluan.string' => 'Kata laluan mesti merupakan rentetan yang sah.',
                'kata_laluan.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
                'kata_laluan.max' => 'Kata laluan tidak boleh melebihi 12 aksara.',
                'kata_laluan.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor, dan satu simbol khas.',
                'kata_laluan.different' => 'Kata laluan tidak boleh sama dengan Nombor Kad Pengenalan.',
            ],
        );

        // Encrypt kad_pengenalan before saving
        $encryptedKadPengenalan = Crypt::encryptString($validated['kad_pengenalan']);

        $user = Pengguna::create([
            'nama' => $validated['nama'],
            'kad_pengenalan' => $encryptedKadPengenalan,
            'bahagian_id' => $validated['bahagian_id'],
            'jawatan' => $validated['jawatan'],
            'email' => $validated['email'],
            'no_tel' => $validated['no_tel'],
            'status' => 0, // New users are set as 0 = 'pending'
            'kata_laluan' => Hash::make($validated['kata_laluan']),
        ]);

         // Assign the selected role to the user
    $role = Role::findByName($validated['role']); // Find the role by name
    if ($role) {
        $user->syncRoles($role); // Sync the selected role with the user

        // Explicitly sync the permissions associated with the role to the user
        $permissions = $role->permissions; // Get the permissions of the role
        $user->syncPermissions($permissions); // Sync them to the user
    } else {
        return back()->withErrors(['role' => 'Role not found!']);
    }

        Mail::to($user->email)->send(new UserRegistrationMail($user));

        // Send email to super admins (role_id = 1)
        $superAdmins = Pengguna::whereHas('roles', function ($query) {
            $query->where('id', 1); // Assuming 1 is the ID for the super admin role
        })->get();

        foreach ($superAdmins as $superAdmin) {
            // Send the registration notification email to each super admin
            Mail::to($superAdmin->email)->send(new AdminUserRegistrationNotification($user));
        }

        // DB::table('activity_log')->insert([
        //     'log_name' => 'Pendaftaran Baharu',
        //     'description' => 'Pengguna Baharu Melakukan Pendaftaran.',
        //     'subject_type' => 'App\Models\Pengguna',
        //     'subject_id' => $user->id,
        //     'causer_type' => Auth::check() ? 'App\Models\User' : null,
        //     'causer_id' => Auth::id(),
        //     'properties' => json_encode(['user' => $user]),
        //     'created_at' => now(),
        // ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Terima kasih kerana menghantar pendaftaran. Permohonan anda sedang diproses, dan sila semak email anda untuk maklumat lanjut.');
    }

    public function getRolesByBahagian($bahagian_id)
    {
        // Define role IDs based on bahagian_id
        // Modify this mapping based on your actual business logic
        $rolesMapping = [
            1 => [1,2],
            2 => [6, 15],
            3 => [13, 22],
            4 => [8, 17],
            5 => [9, 18],
            6 => [7,16],
            7 => [10, 19], 
            9 => [12,21],
            10 => [11,20],
            12 => [5,14],
        ];

        // Get the role IDs for the selected bahagian_id
        $roleIds = $rolesMapping[$bahagian_id] ?? [];

        // Fetch the roles using Spatie, if any are defined
        $roles = Role::whereIn('id', $roleIds)->get();

        return response()->json(['roles' => $roles]);
    }


    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session to prevent reuse
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF issues
        $request->session()->regenerateToken();

        // Redirect to the login page or any other page after logout
        return redirect()->route('auth.login');
    }
}

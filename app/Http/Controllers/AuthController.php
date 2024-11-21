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
            'kad_pengenalan.required' => 'Kad Pengenalan is required.',
            'kata_laluan.required' => 'Kata Laluan is required.',
        ]);

        // Retrieve user from the pengguna table
        $user = Pengguna::where('kad_pengenalan', $validatedData['kad_pengenalan'])->first();

        if (!$user) {
            // Kad Pengenalan does not exist
            return back()->withErrors([
                'kad_pengenalan' => 'Kad Pengenalan tidak wujud.',
            ]);
        }

        if (!Hash::check($validatedData['kata_laluan'], $user->kata_laluan)) {
            // Kata Laluan is incorrect
            return back()->withErrors([
                'kata_laluan' => 'Kata Laluan tidak sah.',
            ]);
        }

        if ($user->status === "0") {
            // Status is "0", indicating the account is pending approval
            return back()->withErrors([
                'status' => 'Akaun anda belum diluluskan oleh pentadbir. Sila tunggu sehingga akaun anda disahkan.',
            ]);
        }

        if ($user->status !== "1") {
            // Status is not "1", so login is not allowed
            return back()->withErrors([
                'status' => 'Akaun anda tidak aktif. Sila hubungi pentadbir.',
            ]);
        }

        // Log the user in if status is 1
        Auth::login($user);
        
        // Redirect or return response
        return redirect()->intended(route('administration.manage_account'));
    }

    public function forgotPassword(Request $request) 
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send the reset link to the user's email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Check if the status is successful or not
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => 'Pautan tetapan semula kata laluan telah dihantar ke emel anda!']);
        } else {
            return back()->withErrors(['email' => 'Kami tidak dapat mencari pengguna dengan emel itu.']);
        }
    }

    public function resetPassword(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Custom logic for password reset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Pengguna $pengguna, string $password) {
                // Use 'kata_laluan' column instead of 'password'
                $pengguna->forceFill([
                    'kata_laluan' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $pengguna->save();

                // Fire password reset event
                event(new PasswordReset($pengguna));
            }
        );

        // Return response based on the password reset status
        if ($status === Password::PASSWORD_RESET) {
                    return redirect()->route('auth.login')->with('status', 'Kata laluan anda telah berjaya ditetapkan semula!');
         } else {
                    return back()->withErrors(['email' => [__($status)]]);
            }
    }
    

    public function showRegisterForm() {

        $bahagian = Agensi::get();

        return view('auth.register', compact('bahagian'));
    }

    public function registration_process(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'kad_pengenalan' => 'required|string|max:20|unique:pengguna',
            'bahagian' => 'required|string|max:255',
            'jawatan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'no_tel' => 'required|string|max:15',
            'kata_laluan' => 'required|string|min:8',
        ], [
            'nama.required' => 'Nama is required.',
            'nama.string' => 'Nama must be a valid string.',
        
            'kad_pengenalan.required' => 'Kad Pengenalan is required.',
            'kad_pengenalan.string' => 'Kad Pengenalan must be a valid string.',
            'kad_pengenalan.max' => 'Kad Pengenalan cannot exceed 20 characters.',
            'kad_pengenalan.unique' => 'Kad Pengenalan telah wujud.',
        
            'bahagian.required' => 'Bahagian is required.',
            'bahagian.string' => 'Bahagian must be a valid string.',
            'bahagian.max' => 'Bahagian cannot exceed 255 characters.',
        
            'jawatan.required' => 'Jawatan is required.',
            'jawatan.string' => 'Jawatan must be a valid string.',
            'jawatan.max' => 'Jawatan cannot exceed 255 characters.',
        
            'email.required' => 'email is required.',
            'email.string' => 'email must be a valid string.',
            'email.email' => 'email must be a valid email address.',
            'email.max' => 'email cannot exceed 255 characters.',
            'email.unique' => 'email telah wujud.',
        
            'no_tel.required' => 'No Tel is required.',
            'no_tel.string' => 'No Tel must be a valid string.',
            'no_tel.max' => 'No Tel cannot exceed 15 characters.',
        
            'kata_laluan.required' => 'Kata Laluan is required.',
            'kata_laluan.string' => 'Kata Laluan must be a valid string.',
            'kata_laluan.min' => 'Kata Laluan must be at least 8 characters.',
        ]);

        // Retrieve the bahagian name based on the selected ID
        $bahagianName = Agensi::where('id', $request->bahagian)->value('name');
        
        $user = Pengguna::create([
            'nama' => $request->nama,
            'kad_pengenalan' => $request->kad_pengenalan,
            'bahagian' => $bahagianName,
            'jawatan' => $request->jawatan,
            'email' => $request->email,
            'no_tel' => $request->no_tel,
            'status' => 0, // New users are set as 0 = 'pending'
            'kata_laluan' => Hash::make($request->kata_laluan),
        ]);

        Mail::to($user->email)->send(new UserRegistrationMail($user));

         // Send email to super admins (role_id = 1)
        $superAdmins = Pengguna::whereHas('roles', function ($query) {
            $query->where('id', 1);  // Assuming 1 is the ID for the super admin role
        })->get();

        foreach ($superAdmins as $superAdmin) {
            // Send the registration notification email to each super admin
            Mail::to($superAdmin->email)->send(new AdminUserRegistrationNotification($user));
        }

        // Redirect with success message
        return redirect()->back()->with('success', 'Terima kasih kerana menghantar pendaftaran. Permohonan anda sedang diproses, dan sila semak email anda untuk maklumat lanjut.');
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

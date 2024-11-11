<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministrationController extends Controller
{
    public function manage_account() 
    {
        $userProfile = Auth::user()->load('Peranan');
        return view ('administration.manage_account', compact('userProfile'));
    }

    public function manage_account_profile(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tel' => 'nullable|string|max:15', // Adjust the validation rule based on your requirements
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's profile
        $user->nama = $validatedData['nama'];
        $user->no_tel = $validatedData['no_tel'];
        
        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Maklumat berjaya dikemaskini.');
    }

    public function manage_account_password (Request $request)
    {
        // Validate the request
        $request->validate([
            'kata_laluan_baharu' => 'required', // New password must be required
            'kata_laluan_pengesahan' => 'required', // Current password must be required
        ], [
            'kata_laluan_baharu.required' => 'Sila masukkan kata laluan baharu.', // Custom message for new password required
            'kata_laluan_pengesahan.required' => 'Sila masukkan kata laluan pengesahan.', // Custom message for current password required
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the provided current password matches the stored password
        if (!Hash::check($request->kata_laluan_pengesahan, $user->kata_laluan)) {
            return back()->withErrors(['kata_laluan_pengesahan' => 'Kata laluan pengesahan tidak betul.']); // Return error if current password is incorrect
        }

        // Update the password
        $user->kata_laluan = Hash::make($request->kata_laluan_baharu); // Hash the new password and store it
        $user->save(); // Save the updated user

        return back()->with('success', 'Kata laluan telah berjaya dikemaskini.'); // Return success message
    }

    public function pengurusan_pengguna_list() {
        $pengguna_belum_berdaftar = Pengguna::where('status', '0')->get();
        $senaraiPengguna = Pengguna::where('status', '1')
        ->orWhere('status', '2')
        ->get();

        return view('administration.pengurusan_pengguna', compact('pengguna_belum_berdaftar', 'senaraiPengguna'));
    }
    

}

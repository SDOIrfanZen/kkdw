<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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

    public function tambah_pengguna_list() {
        $roles = Role::all();
        return view ('administration.pengguna_create', compact('roles'));
    }

    public function tambah_pengguna_process (Request $request) 
    {
        $customMessages = [
            'nama.required' => 'Nama Penuh diperlukan.',
            'nama.string' => 'Nama Penuh mesti dalam bentuk teks.',
            'nama.max' => 'Nama Penuh tidak boleh melebihi 255 aksara.',
            
            'peranan.required' => 'Peranan diperlukan.',
            'peranan.string' => 'Peranan mesti dalam bentuk teks.',
            'peranan.max' => 'Peranan tidak boleh melebihi 255 aksara.',
            
            'kad_pengenalan.required' => 'Kad Pengenalan diperlukan.',
            'kad_pengenalan.numeric' => 'Kad Pengenalan mesti dalam format nombor.',
            'kad_pengenalan.unique' => 'Kad Pengenalan ini sudah wujud.',
            
            'emel.required' => 'Alamat e-mel rasmi diperlukan.',
            'emel.email' => 'Alamat e-mel rasmi mesti dalam format yang sah.',
            'emel.unique' => 'Alamat e-mel rasmi ini sudah digunakan.',
            
            'bahagian.required' => 'Bahagian/Agensi/Institusi diperlukan.',
            'bahagian.string' => 'Bahagian/Agensi/Institusi mesti dalam bentuk teks.',
            'bahagian.max' => 'Bahagian/Agensi/Institusi tidak boleh melebihi 255 aksara.',
            
            'no_tel.required' => 'No Telefon diperlukan.',
            'no_tel.string' => 'No Telefon mesti dalam format nombor.',
            
            'jawatan.required' => 'Jawatan diperlukan.',
            'jawatan.string' => 'Jawatan mesti dalam bentuk teks.',
            'jawatan.max' => 'Jawatan tidak boleh melebihi 255 aksara.',

            'kata_laluan.required' => 'Kata Laluan is required.',
            'kata_laluan.string' => 'Kata Laluan must be a valid string.',
            'kata_laluan.min' => 'Kata Laluan must be at least 8 characters.',
        ];
    
        // Validate the incoming data with custom messages
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'peranan' => 'required|string|exists:roles,name',
            'kad_pengenalan' => 'required|numeric|unique:Pengguna,kad_pengenalan',
            'emel' => 'required|email|unique:Pengguna,emel',
            'bahagian' => 'required|string|max:255',
            'no_tel' => 'required|string',
            'jawatan' => 'required|string|max:255',
            'kata_laluan' => 'required|string|min:8',
        ], $customMessages); // Pass custom messages as second parameter
    
        // Store the validated data
        $user = Pengguna::create([
            'nama' => $validated['nama'],
            'kad_pengenalan' => $validated['kad_pengenalan'],
            'emel' => $validated['emel'],
            'bahagian' => $validated['bahagian'],
            'no_tel' => $validated['no_tel'],
            'jawatan' => $validated['jawatan'],
            'status' => "1",
            'kata_laluan' => Hash::make($request->kata_laluan),
        ]);

        // Assign the selected role to the user
        $role = Role::findByName($validated['peranan']); // Get the role by its name
        $user->assignRole($role); // Assign the role to the user
    
        // Redirect with success message
        return redirect()->route('administration.pengurusan_pengguna')->with('success', 'Pengguna berjaya ditambah!');
    }
    
    

}

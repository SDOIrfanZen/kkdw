<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Agensi;
use Illuminate\Http\Request;
use App\Mail\UserRejectionMail;
use App\Models\RejectedPengguna;
use App\Mail\AccountApprovedMail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;

class AdministrationController extends Controller
{
    public function manage_account()
    {
        $userProfile = Auth::user();
        return view('administration.manage_account', compact('userProfile'));
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

    public function manage_account_password(Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'kata_laluan_baharu' => [
                    'required',
                    'min:8',
                    'max:12',
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[0-9]/', // At least one number
                    'regex:/[\W_]/', // At least one symbol (non-word character or special character)
                    function ($attribute, $value, $fail) use ($request) {
                        // Custom validation to ensure password does not match Kad Pengenalan
                        if ($value === $request->kad_pengenalan) {
                            $fail('Kata laluan tidak boleh sama dengan Kad Pengenalan.');
                        }
                    },
                ],
                'kata_laluan_pengesahan' => 'required|same:kata_laluan_baharu', // Ensure confirmation matches new password
            ],
            [
                'kata_laluan_baharu.required' => 'Sila masukkan kata laluan baharu untuk kemas kini.',
                'kata_laluan_baharu.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
                'kata_laluan_baharu.max' => 'Kata laluan baharu tidak boleh melebihi 12 aksara.',
                'kata_laluan_baharu.regex' => 'Kata laluan baharu mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor, dan satu simbol.',
                'kata_laluan_pengesahan.required' => 'Sila masukkan kata laluan pengesahan.',
                'kata_laluan_pengesahan.same' => 'Kata laluan baharu dan kata laluan pengesahan tidak sepadan. Sila pastikan kedua-duanya adalah sama.',
            ],
        );

        $user = Auth::user();

        // Update the password
        $user->kata_laluan = Hash::make($request->kata_laluan_baharu); // Hash the new password
        $user->save(); // Save the updated user

        // Redirect with success message
        return back()->with('success', 'Kata laluan telah berjaya dikemaskini.');
    }

    public function pengurusan_pengguna_main()
    {
        return view('administration.pengurusan_pengguna.homepage_pengurusan_pengguna');
    }

    public function pengurusan_pengguna_list()
    {
        $pengguna_belum_berdaftar = Pengguna::where('status', '0')->get();
        $senaraiPengguna = Pengguna::where('status', '1')->orWhere('status', '2')->get();

        return view('administration.pengurusan_pengguna.pengurusan_pengguna', compact('pengguna_belum_berdaftar', 'senaraiPengguna'));
    }

    public function tambah_pengguna_list()
    {
        $roles = Role::all();
        $bahagian = Agensi::get();
        return view('administration.pengurusan_pengguna.pengguna_create', compact('roles', 'bahagian'));
    }

    public function tambah_pengguna_process(Request $request)
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

            'email.required' => 'Alamat e-mel rasmi diperlukan.',
            'email.email' => 'Alamat e-mel rasmi mesti dalam format yang sah.',
            'email.unique' => 'Alamat e-mel rasmi ini sudah digunakan.',

            'bahagian_id.required' => 'Bahagian/Agensi/Institusi diperlukan.',
            'bahagian_id.string' => 'Bahagian/Agensi/Institusi mesti dalam bentuk teks.',
            'bahagian_id.max' => 'Bahagian/Agensi/Institusi tidak boleh melebihi 255 aksara.',

            'no_tel.required' => 'No Telefon diperlukan.',
            'no_tel.string' => 'No Telefon mesti dalam format nombor.',

            'jawatan.required' => 'Jawatan diperlukan.',
            'jawatan.string' => 'Jawatan mesti dalam bentuk teks.',
            'jawatan.max' => 'Jawatan tidak boleh melebihi 255 aksara.',

            'kata_laluan.required' => 'Kata Laluan diperlukan.',
            'kata_laluan.string' => 'Kata Laluan must be a valid string.',
            'kata_laluan.min' => 'Kata Laluan sekurang-kurangnya 8 aksara.',
        ];

        // Validate the incoming data with custom messages
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'peranan' => 'required|string|exists:roles,name',
                'kad_pengenalan' => 'required|numeric|unique:pengguna,kad_pengenalan',
                'email' => 'required|email|unique:pengguna,email',
                'bahagian_id' => 'required|string|max:255',
                'no_tel' => 'required|string',
                'jawatan' => 'required|string|max:255',
                'kata_laluan' => 'required|string|min:8',
            ],
            $customMessages,
        ); // Pass custom messages as second parameter

        $encryptedKadPengenalan = Crypt::encryptString($validated['kad_pengenalan']);

        // Store the validated data
        $user = Pengguna::create([
            'nama' => $validated['nama'],
            'kad_pengenalan' => $encryptedKadPengenalan,
            'email' => $validated['email'],
            'bahagian_id' => $validated['bahagian_id'],
            'no_tel' => $validated['no_tel'],
            'jawatan' => $validated['jawatan'],
            'status' => '1',
            'kata_laluan' => Hash::make($request->kata_laluan),
        ]);

        // Assign the selected role to the user
        $role = Role::findByName($validated['peranan']); // Get the role by its name
        $user->assignRole($role); // Assign the role to the user

        // Sync permissions associated with the role
        $permissions = $role->permissions; // Get all permissions for the role
        $user->syncPermissions($permissions); // Sync permissions to the user

        // Redirect with success message
        return redirect()->route('administration.pengurusan_pengguna')->with('success', 'Pengguna berjaya ditambah!');
    }

    public function getRolesForBahagian(Request $request)
    {
        // Your roles mapping
        $rolesMapping = [
            1 => [1, 2],
            2 => [6, 15],
            3 => [13, 22],
            4 => [8, 17],
            5 => [9, 18],
            6 => [7, 16],
            7 => [10, 19],
            9 => [12, 21],
            10 => [11, 20],
            12 => [5, 14],
        ];

        // Get the role IDs for the selected bahagian_id
        $bahagianId = $request->bahagian_id;
        $roleIds = $rolesMapping[$bahagianId] ?? [];

        // Fetch the roles using Spatie, if any are defined
        $roles = Role::whereIn('id', $roleIds)->get();

        return response()->json(['roles' => $roles]);
    }

    public function pengguna_approval_list($id)
    {
        $userProfile = Pengguna::findorFail($id);
        $roles = Role::all();
        return view('administration.pengurusan_pengguna.pengguna_approval', compact('userProfile', 'roles'));
    }

    public function pengguna_approval_process(Request $request, $id)
    {
        // Custom validation messages for role and status
        $customMessages = [
            'role.required' => 'Peranan diperlukan.',
            'role.exists' => 'Peranan yang dipilih tidak sah.',
        ];

        // Validate the incoming data
        $validated = $request->validate(
            [
                'role' => 'required|exists:roles,name', // Validate role selection
            ],
            $customMessages,
        );

        // Find the user by ID
        $user = Pengguna::findOrFail($id); // Assuming you're working with a 'User' model

        // Update the user status to 1 (aktif)
        $user->status = '1'; // Approved status (assuming 1 means approved)

        // Assign the selected role to the user
        $role = Role::findByName($validated['role']); // Find the role by name
        if ($role) {
            $user->syncRoles($role); // Sync the selected role with the user
        } else {
            return back()->withErrors(['role' => 'Role not found!']);
        }

        // Save the changes
        $user->save();

        // Send the approval email
        Mail::to($user->email)->send(new AccountApprovedMail($user));

        // Redirect back with a success message
        return redirect()->route('administration.pengurusan_pengguna')->with('success', 'Akaun pengguna telah berjaya diluluskan dan kini aktif!');
    }

    public function pengguna_reject_process(Request $request, $id)
    {
        // Validate the remark input
        $request->validate([
            'remark' => 'required|string|max:255',
        ]);

        $user = Pengguna::findOrFail($id);

        // Create a new record in the rejected_pengguna table using Eloquent
        RejectedPengguna::create([
            'nama' => $user->nama,
            'role' => $user->role,
            'kad_pengenalan' => $user->kad_pengenalan,
            'email' => $user->email,
            'bahagian' => $user->bahagian,
            'no_tel' => $user->no_tel,
            'jawatan' => $user->jawatan,
            'remark' => $request->input('remark'), // The remark entered by the user
            'created_at' => now(), // Set the current timestamp
            'updated_at' => now(), // Set the current timestamp
        ]);

        // Delete the user from the pengguna table
        $user->delete();

        // Send the rejected email
        Mail::to($user->email)->send(new UserRejectionMail($user, $request->input('remark')));

        // Redirect back with a success message
        return redirect()->route('administration.pengurusan_pengguna')->with('successReject', 'Pengguna berjaya ditolak dan dipadamkan.');
    }

    public function edit_pengguna($id)
    {
        $userProfile = Pengguna::findorFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        $userPermissions = $userProfile->getAllPermissions()->pluck('id')->toArray();
        $bahagian = Agensi::get();
        return view('administration.pengurusan_pengguna.pengguna_edit', compact('userProfile', 'roles', 'permissions', 'userPermissions', 'bahagian'));
    }

    public function update_pengguna(Request $request, $id)
    {
        // Define custom validation messages
        $customMessages = [
            'nama.required' => 'Nama Penuh diperlukan.',
            'nama.string' => 'Nama Penuh mesti dalam bentuk teks.',
            'nama.max' => 'Nama Penuh tidak boleh melebihi 255 aksara.',

            'kad_pengenalan.required' => 'Kad Pengenalan diperlukan.',
            'kad_pengenalan.numeric' => 'Kad Pengenalan mesti dalam format nombor.',

            'email.required' => 'Alamat e-mel rasmi diperlukan.',
            'email.email' => 'Alamat e-mel rasmi mesti dalam format yang sah.',
            'email.unique' => 'Alamat e-mel rasmi ini sudah digunakan.',

            'bahagian.required' => 'Bahagian/Agensi/Institusi diperlukan.',
            'bahagian.string' => 'Bahagian/Agensi/Institusi mesti dalam bentuk teks.',
            'bahagian.max' => 'Bahagian/Agensi/Institusi tidak boleh melebihi 255 aksara.',

            'no_tel.required' => 'No Telefon diperlukan.',
            'no_tel.string' => 'No Telefon mesti dalam format nombor.',

            'jawatan.required' => 'Jawatan diperlukan.',
            'jawatan.string' => 'Jawatan mesti dalam bentuk teks.',
            'jawatan.max' => 'Jawatan tidak boleh melebihi 255 aksara.',

            'status.required' => 'Status diperlukan.',
            'status.in' => 'Status mesti dalam pilihan yang sah.',
        ];

        // Validate the incoming data with custom messages
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'kad_pengenalan' => 'required', // Unique check can be skipped for updating
                'email' => 'required|email|unique:pengguna,email,' . $id, // Update with unique constraint excluding current user's email
                'bahagian' => 'required|string|max:255',
                'no_tel' => 'required|string',
                'jawatan' => 'required|string|max:255',
                'status' => 'required|string|in:1,2',
            ],
            $customMessages,
        );

        // Find the user by ID
        $user = Pengguna::findOrFail($id);

        // Encrypt kad_pengenalan before updating
        $encryptedKadPengenalan = Crypt::encryptString($validated['kad_pengenalan']);

        // Update the user's profile
        $user->update([
            'nama' => $validated['nama'],
            'kad_pengenalan' => $encryptedKadPengenalan,
            'email' => $validated['email'],
            'bahagian' => $validated['bahagian'],
            'no_tel' => $validated['no_tel'],
            'jawatan' => $validated['jawatan'],
            'status' => $validated['status'] ?? $user->status, // Keep the old status if not updated
        ]);

        // If password is provided, update it
        // if ($request->filled('kata_laluan')) {
        //     $user->kata_laluan = Hash::make($validated['kata_laluan']);
        // }

        // $role = Role::find($validated['role']); // Find the role by its ID
        // if ($role) {
        //     $user->syncRoles($role); // Sync the role with the new role
        // } else {
        //     return back()->withErrors(['role' => 'Role not found!']);
        // }

        // Redirect with success message
        return redirect()->route('administration.pengurusan_pengguna')->with('success', 'Pengguna berjaya dikemaskini!');
    }

    public function assignRoles(Request $request, $userId)
    {
        $user = Pengguna::findOrFail($userId);

        // Validate input
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array', // Add validation for permissions array
        ]);

        // Get the selected role
        $roleId = $request->input('role');
        $role = Role::findOrFail($roleId);

        // Check if the role has changed
        $currentRole = $user->roles->first();

        // If the role has changed, reset the permissions to the default ones of the selected role
        if ($currentRole && $currentRole->id != $role->id) {
            // Sync the role (this will remove old roles and assign the new one)
            $user->syncRoles([$role->name]);

            // Get the default permissions for the selected role
            $permissions = $role->permissions;

            // Sync the permissions (reset to the new role's permissions)
            $user->syncPermissions($permissions);
        } else {
            // If the role has not changed, just add the additional permissions
            $permissions = $role->permissions; // Default permissions associated with the role

            // If the user selected additional permissions, merge them
            if ($request->has('permissions')) {
                $additionalPermissions = $request->input('permissions');
                $additionalPermissions = Permission::whereIn('id', $additionalPermissions)->get();
                // Merge the default permissions with the additional ones selected by the user
                $permissions = $permissions->merge($additionalPermissions);
            }

            // Sync the permissions (add new ones but preserve existing role permissions)
            $user->syncPermissions($permissions);
        }

        return redirect()->back()->with('success', 'Peranan dan capaian berjaya dikemaskini!');
    }

    public function update_pengguna_password(Request $request, $id)
    {
        // Validate the request
        $request->validate(
            [
                'kata_laluan_baharu' => [
                    'required',
                    'string',
                    'min:8', // Minimum 8 characters
                    'max:12', // Maximum 12 characters
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[0-9]/', // At least one number
                    'regex:/[\W_]/', // At least one symbol (non-word character or special character)
                    function ($attribute, $value, $fail) use ($request) {
                        // Custom validation to ensure password does not exactly match Kad Pengenalan
                        if ($value === $request->kad_pengenalan) {
                            $fail('Kata laluan tidak boleh sama dengan Kad Pengenalan.');
                        }
                    },
                ],
                'kata_laluan_pengesahan' => 'required|same:kata_laluan_baharu', // Ensure confirmation matches new password
            ],
            [
                'kata_laluan_baharu.required' => 'Sila masukkan kata laluan baharu untuk kemas kini.',
                'kata_laluan_baharu.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
                'kata_laluan_baharu.max' => 'Kata laluan baharu tidak boleh melebihi 12 aksara.',
                'kata_laluan_baharu.regex' => 'Kata laluan baharu mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor, dan satu simbol.',
                'kata_laluan_pengesahan.required' => 'Sila masukkan kata laluan pengesahan.',
                'kata_laluan_pengesahan.same' => 'Kata laluan baharu dan kata laluan pengesahan tidak sepadan. Sila pastikan kedua-duanya adalah sama.',
            ],
        );

        // Find the user by ID
        $user = Pengguna::findOrFail($id);

        // Update the password
        $user->kata_laluan = Hash::make($request->kata_laluan_baharu); // Hash the new password
        $user->save(); // Save the updated user

        // Redirect with success message
        return back()->with('success', 'Kata laluan telah berjaya dikemaskini.');
    }

    public function delete_pengguna($id)
    {
        $user = Pengguna::findOrFail($id);

        // Ensure you perform any necessary checks like authorization

        $user->delete();

        return redirect()->route('administration.pengurusan_pengguna')->with('success', 'Pengguna berjaya dihapus.');
    }

    public function senarai_peranan()
    {
        // Fetch roles with their associated users and permissions
        $roles = Role::with(['users', 'permissions'])->get();

        // Return the view with the roles data
        return view('administration.pengurusan_pengguna.peranan_list', compact('roles'));
    }

    public function kemaskini_peranan($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('administration.pengurusan_pengguna.kemaskini_peranan', compact('role', 'permissions'));
    }

    public function update_peranan(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'nama' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        // Find the role by ID
        $role = Role::findOrFail($id);

        // Update the role name
        $role->name = $request->input('nama');
        $role->save();

        // Sync the selected permissions with the role
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('name', $request->input('permissions'))->get();
            $role->syncPermissions($permissions);
        } else {
            // If no permissions are selected, revoke all permissions
            $role->syncPermissions([]);
        }

        // Redirect back with a success message
        return redirect()->route('administration.kemaskini_peranan', $id)->with('success', 'Peranan berjaya dikemaskini.');
    }

    public function tambah_peranan_list()
    {
        // Fetch necessary data for the form, such as permissions
        $permissions = Permission::all();

        // Return the view for the add role form
        return view('administration.pengurusan_pengguna.tambah_peranan', compact('permissions'));
    }

    public function tambah_peranan(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            // Create a new role
            $role = Role::create(['name' => $request->name]);

            // Assign selected permissions to the role
            $permissions = Permission::whereIn('name', $request->permissions)->get();
            $role->syncPermissions($permissions);

            // Redirect back with success message
            return redirect()->route('administration.senarai_peranan')->with('success', 'Peranan berjaya ditambah.');
        } catch (Exception $e) {
            // Handle exceptions
            return back()
                ->withErrors(['error' => 'Ralat berlaku: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function padam_peranan($id)
    {
        $role = Role::findOrFail($id);

        // Delete the role
        $role->delete();

        return redirect()->route('administration.senarai_peranan')->with('success', 'Peranan berjaya dipadamkan.');
    }

    // pengurusan data

    public function pengurusan_data_main()
    {
        return view('administration.pengurusan_data.homepage_pengurusan_data');
    }

    // dashboard
    public function dashboard_main()
    {
        return view('administration.dashboard.homepage_dashboard');
    }

    public function audit_trail_main()
    {
        return view('administration.audit_trail.homepage_audit_trail');
    }

    public function audit_trail_list()
    {
        return view('administration.audit_trail.audit_trail_list');
    }
}

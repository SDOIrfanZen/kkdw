@extends('layout.master')

<style>
    .label-column {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
    }

    form .btn {
        box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.25);
        width: 9%;
        text-shadow: none;
        outline: none;
    }

    form .btn-primary {
        background: rgba(35, 44, 108, 1);
        border: none;
        border-radius: 4px;
    }

    form .btn-reset {
        border: 1px solid rgba(211, 211, 211, 1);
        border: none;
        border-radius: 4px;
    }

    input[readonly].form-control {
        background-color: rgba(217, 217, 217, 1);
        /* Light grey */
        cursor: not-allowed;
        /* Indicate that the input is not editable */
    }
</style>

@section('content')
<div class="mx-auto" style="width: 90%;">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
</div>
    @endif



    <div class="container-fluid d-flex justify-content-center">
        <div class="card mt-4 mx-auto" style="width: 90%;">
            <div class="card-header d-flex align-items-center custom-card-header"
                style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
                <img src="{{ asset('images/user-information.svg') }}" alt="Profile Icon" class="me-2"
                    style="width: 24px; height: 24px;">
                Maklumat Profil
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('administration.update_pengguna', $userProfile->id) }}" id=""
                    class="m-3">
                    @csrf
                    @method('PUT')
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Nama Penuh</div>
                        <div class="col-md-3">
                            <input class="form-control" name="nama" value="{{ $userProfile->nama }}">
                        </div>
                        <div class="col-md-3 label-column">Status</div>
                        <div class="col-md-3">
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ $userProfile->status == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="2" {{ $userProfile->status == '2' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                        {{-- <div class="col-md-3 label-column">Peranan</div>
                        <div class="col-md-3">
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $userProfile->roles->first()->id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Kad Pengenalan</div>
                        <div class="col-md-3">
                            <input class="form-control" name="kad_pengenalan" value="{{ \Crypt::decryptString($userProfile->kad_pengenalan) }}">
                        </div>
                        <div class="col-md-3 label-column">Alamat e-mel rasmi</div>
                        <div class="col-md-3">
                            <input class="form-control" name="email" value="{{ $userProfile->email }}">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Bahagian/Agensi/Institusi</div>
                        <div class="col-md-3">
                            <input class="form-control" name="bahagian" value="{{ $userProfile->bahagian }}">
                        </div>
                        <div class="col-md-3 label-column">No Telefon</div>
                        <div class="col-md-3">
                            <input class="form-control" name="no_tel" value="{{ $userProfile->no_tel }}">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Jawatan</div>
                        <div class="col-md-3">
                            <input class="form-control" name="jawatan" value="{{ $userProfile->jawatan }}">
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-primary me-3" type="submit">Kemaskini</button>
                        <button class="btn btn-reset" type="button">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="card mt-4 mx-auto" style="width: 90%;">
            <div class="card-header d-flex align-items-center custom-card-header"
                style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
                <img src="{{ asset('images/kata-laluan.svg') }}" alt="Profile Icon" class="me-2"
                    style="width: 24px; height: 24px;">
                Kata Laluan
            </div>
            <div class="card-body" style="height: 250px;">
                <form method="post" action="{{ route('administration.update_pengguna_password', $userProfile->id) }}"
                    id="updatePasswordForm" class="d-flex flex-column h-100">
                    @csrf
                    @method('PUT')
                    <div class="flex-grow-1">
                        <!-- Kata Laluan Baharu -->
                        <div class="row pb-2">
                            <div class="col-md-3 label-column">Kata Laluan Baharu</div>
                            <div class="col-md-3">
                                <input type="password" class="form-control" name="kata_laluan_baharu" required>
                                @error('kata_laluan_baharu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Kata Laluan Pengesahan -->
                        <div class="row pb-2">
                            <div class="col-md-3 label-column">Kata Laluan Pengesahan</div>
                            <div class="col-md-3">
                                <input type="password" class="form-control" name="kata_laluan_pengesahan" required>
                                @error('kata_laluan_pengesahan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Buttons at Bottom Right -->
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary me-3" type="submit">Simpan</button>
                        <button class="btn btn-reset" type="button" onclick="window.history.back();">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <!-- Big Card -->
        <div class="card mt-4 mx-auto" style="width: 90%;">
            <!-- Card Header -->
            <div class="card-header d-flex align-items-center custom-card-header"
                style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
                <img src="{{ asset('images/peranan-capaian-icon.png') }}" alt="Profile Icon" class="me-2"
                    style="width: 24px; height: 24px;">
                Peranan Dan Capaian
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('assign-roles', $userProfile->id) }}" method="POST">
                    @csrf

                    <!-- Mini-Card for Roles -->
                    <div class="card mb-4">
                        <div class="card-header" style="background: rgba(8, 12, 85, 0.9); color: white; height: 3rem;">
                            Peranan
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-2 mb-2"> <!-- Dividing into 6 equal parts for 5 in a row -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                value="{{ $role->id }}" id="role-{{ $role->id }}"
                                                {{ in_array($role->id, $userProfile->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>



                    <!-- Card for Permissions -->
                    <div class="card shadow-sm">
                        <div class="card-header" style="background: rgba(8, 12, 85, 0.9); color: white; height: 3rem;">
                            <h5 class="mb-0">Capaian</h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <!-- Group: Pengurusan Pengguna -->
                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Pengurusan Pengguna</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 1 && $permission->id <= 6)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Group: Pengurusan Peranan -->
                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Pengurusan Peranan</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 7 && $permission->id <= 11)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Additional Permission Groups -->
                                    <!-- Group: Dashboard -->
                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Dashboard</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 16 && $permission->id <= 22)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Continue other permission groups similarly -->
                                    <!-- Group: Pengurusan Data -->
                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Pengurusan Data</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 13 && $permission->id <= 15)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Pengurusan Profil</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 23 && $permission->id <= 25)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Final Permission Groups -->
                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Audit Trail</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 26 && $permission->id <= 28)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <h4 class="">Sistem</h4>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->id >= 29 && $permission->id <= 41)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Align Delete Button to the Right -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Kemaskini</button>
                        <!-- Trigger Button for Modal -->
                        <button type="button" class="btn btn-danger" style="width: 100px;" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            Hapus
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Sahkan Pemadaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Adakah anda pasti mahu menghapus pengguna ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('administration.delete_pengguna', $userProfile->id) }}"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 80px;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

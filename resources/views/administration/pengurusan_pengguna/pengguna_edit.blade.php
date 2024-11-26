@extends('layout.master')

<style>
    .label-column {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
    }

    form .btn {
        box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.25);
        width: 8%;
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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
                        <div class="col-md-3 label-column">Peranan</div>
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
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Kad Pengenalan</div>
                        <div class="col-md-3">
                            <input class="form-control" name="kad_pengenalan" value="{{ $userProfile->kad_pengenalan }}">
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
                        <div class="col-md-3 label-column">Status</div>
                        <div class="col-md-3">
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ $userProfile->status == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="2" {{ $userProfile->status == '2' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
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
                            <div class="col-md-3">
                                <h5>Select Roles</h5>
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                            value="{{ $role->id }}" id="role-{{ $role->id }}"
                                            {{ in_array($role->id, $userProfile->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!-- Mini-Card for Permissions -->
                    <!-- Mini-Card for Permissions -->
                    <div class="card">
                        <!-- Mini-Card for Permissions -->
                        <div class="card">
                            <div class="card-header"
                                style="background: rgba(8, 12, 85, 0.9); color: white; height: 3rem;">
                                Capaian
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5>Select Permissions</h5>
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                                    {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

        </div>
    </div>


    <!-- Align Delete Button to the Right -->
    <div class="d-flex justify-content-end mt-3">
        <!-- Trigger Button for Modal -->
        <button type="button" class="btn btn-danger" style="width: 100px;" data-bs-toggle="modal"
            data-bs-target="#deleteModal">
            Delete
        </button>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('administration.delete_pengguna', $userProfile->id) }}"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 80px;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layout.master')

@section('content')
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="container-fluid d-flex justify-content-center">
        <div class="card mt-4 mx-auto" style="width: 90%; border-radius: 8px;">
            <div class="card-header d-flex align-items-center custom-card-header"
                style="background: rgba(8, 12, 85, 1); height: 3.5rem; color: white;">
                <i class="fas fa-users-cog mr-2"></i> Pengurusan Pengguna > Peranan
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h4><strong>KEMASKINI PERANAN</strong></h4>
                    <div class="container">
                        <form action="{{ route('administration.update_peranan', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Role and Status Section -->
                            <div class="row pb-2">
                                <div class="col-md-3 d-flex align-items-center">
                                    <label for="role-name" class="form-label">Peranan</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="role-name" class="form-control" name="nama"
                                        value="{{ $role->name }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <label for="status" class="form-label">Status</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="status" class="form-control" value="Aktif" readonly>
                                </div>
                            </div>

                            <!-- Permission Groups -->
                            <div class="row mt-5">
                                <!-- Pengurusan Pengguna -->
                                <div class="col-md-4">
                                    <h4>Pengurusan Pengguna</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [1, 6]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pengurusan Peranan -->
                                <div class="col-md-4">
                                    <h4>Pengurusan Peranan</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [7, 12]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Dashboard -->
                                <div class="col-md-4">
                                    <h4>Dashboard</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [15, 21]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Permission Groups -->
                            <div class="row mt-4">
                                <!-- Pengurusan Pengguna -->
                                <div class="col-md-4">
                                    <h4>Pengurusan Data</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [13, 14]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pengurusan Peranan -->
                                <div class="col-md-4">
                                    <h4>Pengurusan Profil</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [22, 24]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Dashboard -->
                                <div class="col-md-4">
                                    <h4>Audit Trail</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [25, 27]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h4>Sistem</h4>
                                    <div class="checkbox-group">
                                        @foreach ($permissions->whereBetween('id', [28, 41]) as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="permission-{{ $permission->id }}" class="form-check-label">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Submit and Back Buttons -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">Kemaskini Peranan</button>
                                <a href="{{ route('administration.senarai_peranan') }}" class="btn btn-secondary ms-2">Kembali</a>
                                <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteRoleModal">Padam Peranan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Padam Peranan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Adakah anda pasti ingin memadamkan peranan ini? Tindakan ini tidak boleh dikembalikan.
            </div>
            <div class="modal-footer">
                <form action="{{ route('administration.delete_peranan', $role->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Padam</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

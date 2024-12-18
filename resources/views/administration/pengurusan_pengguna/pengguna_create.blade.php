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
                Tambah Pengguna
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('administration.tambah_pengguna_process') }}" class="m-3">
                    @csrf
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Nama Penuh</div>
                        <div class="col-md-3">
                            <input class="form-control @error('nama') is-invalid @enderror" name="nama"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 label-column">Peranan</div>
                        <div class="col-md-3">
                            <select class="form-control @error('peranan') is-invalid @enderror" name="peranan" id="peranan">
                                <option value="">Pilih Peranan</option>
                                <!-- Initially, there are no roles until a bahagian is selected -->
                            </select>
                            @error('peranan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Kad Pengenalan</div>
                        <div class="col-md-3">
                            <input class="form-control @error('kad_pengenalan') is-invalid @enderror" name="kad_pengenalan"
                                value="{{ old('kad_pengenalan') }}">
                            @error('kad_pengenalan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 label-column">Alamat e-mel rasmi</div>
                        <div class="col-md-3">
                            <input class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Bahagian/Agensi/Institusi</div>
                        <div class="col-md-3">
                            <select class="form-control" name="bahagian_id" id="bahagian_id" required>
                                <option value="" disabled selected>Sila Pilih</option>
                                @foreach($bahagian as $item)
                                    <option value="{{ $item->id }}" {{ old('bahagian_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bahagian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 label-column">No Telefon</div>
                        <div class="col-md-3">
                            <input class="form-control @error('no_tel') is-invalid @enderror" name="no_tel"
                                value="{{ old('no_tel') }}">
                            @error('no_tel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3 label-column">Jawatan</div>
                        <div class="col-md-3">
                            <input class="form-control @error('jawatan') is-invalid @enderror" name="jawatan"
                                value="{{ old('jawatan') }}">
                            @error('jawatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 label-column">Kata Laluan</div>
                        <div class="col-md-3">
                            <input type="password" class="form-control @error('kata_laluan') is-invalid @enderror" name="kata_laluan"
                                value="{{ old('kata_laluan') }}">
                            @error('kata_laluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary me-3" type="submit">Simpan</button>
                        <button class="btn btn-reset" type="button">Batal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            // Listen for changes on the bahagian_id select box
            $('#bahagian_id').change(function() {
                var bahagianId = $(this).val();
    
                // If no bahagian_id is selected, reset the peranan dropdown to show "No Role"
                if (!bahagianId) {
                    $('#peranan').html('<option value="">Pilih Peranan</option>');  // No role options
                    return;
                }
    
                // Send AJAX request to fetch roles for the selected bahagian_id
                $.ajax({
                    url: '{{ route('administration.getRolesForBahagian') }}',
                    method: 'GET',
                    data: { bahagian_id: bahagianId },
                    success: function(response) {
                        var roles = response.roles;
                        var roleOptions = '<option value="">Pilih Peranan</option>';  // Default option
                        
                        // If roles are returned, populate the dropdown
                        if (roles.length === 0) {
                            roleOptions = '<option value="">Sila Pilih Bahagian Dahulu</option>';
                        } else {
                            roles.forEach(function(role) {
                                roleOptions += `<option value="${role.name}">${role.name}</option>`;
                            });
                        }
    
                        // Update the peranan select box with the new options
                        $('#peranan').html(roleOptions);
                    },
                    error: function() {
                        alert('Error fetching roles');
                    }
                });
            });
    
            // If no bahagian_id is initially selected, show "No Role"
            if (!$('#bahagian_id').val()) {
                $('#peranan').html('<option value="">Sila Pilih Bahagian Dahulu</option>');
            }
        });
    </script>

@endsection

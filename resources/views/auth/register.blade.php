@extends('layout.master-mini')

@section('content')

<div class="login-dark">
    <div class="container-fluid">
        <div class="form-container" style="width: 100%; max-width: 1080px;">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/jata-negara.png') }}" 
                     alt="jata negara logo" 
                     class="logo-image"
                     style="width: 198px; height: 138px; transform: translateY(50px) translateX(22px);"> <!-- Adjust width as needed -->
                     <img src="{{ asset('images/dashboard-eksekutif2.svg') }}" 
                     alt="dashboard eksekutif logo" 
                     class="logo-image"
                     style="width: 302px; height: 279px; transform: translateY(78px) translateX(41px);"> <!-- Adjust width as needed -->
            </div>  
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="post" action="{{ route('auth.registration_process') }}"> 
                @csrf
                <div class="text-center mb-5">
                    <h5><strong>PENDAFTARAN PENGGUNA BARU</strong></h5>
                </div>
            
                <div class="form-row mb-3">
                    <!-- Name Row -->
                    <div class="form-group col-md-4">
                        <label for="nama"><strong>Nama Penuh</strong></label>
                        <input class="form-control" type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Penuh"  oninput="this.value = this.value.toUpperCase()" required>
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    
                    <div class="form-group col-md-4">
                        <label for="kad_pengenalan"><strong>Kad Pengenalan</strong></label>
                        <input class="form-control" type="text" name="kad_pengenalan" value="{{ old('kad_pengenalan') }}" placeholder="Kad Pengenalan" required>
                        @error('kad_pengenalan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="bahagian_id"><strong>Bahagian / Agensi / Institusi</strong></label>
                        <select class="form-control" name="bahagian_id" id="bahagian_id" required>
                            <option value="" disabled selected>Sila Pilih</option>
                            @foreach($bahagian as $item)
                                <option value="{{ $item->id }}" {{ old('bahagian_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('bahagian_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>                 
                    
                </div>
            
                <div class="form-row mb-3">
                    <!-- Jawatan Row -->
                    <div class="form-group col-md-4">
                        <label for="jawatan"><strong>Jawatan</strong></label>
                        <input class="form-control" type="text" name="jawatan" value="{{ old('jawatan') }}" placeholder="Jawatan"  oninput="this.value = this.value.toUpperCase()" required>
                        @error('jawatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="peranan"><strong>Peranan</strong></label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="" disabled selected>Sila Pilih</option>
                            <!-- Roles will be populated dynamically based on bahagian_id -->
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="email"><strong>Alamat E-mel Rasmi</strong></label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Alamat E-mel Rasmi" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="form-row mb-4">
                    <div class="form-group col-md-4">
                        <label for="no_tel"><strong>No. Telefon</strong></label>
                        <input class="form-control" type="text" name="no_tel" value="{{ old('no_tel') }}" placeholder="No. Telefon" required>
                        @error('no_tel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Kata Laluan Row -->
                    <div class="form-group col-md-4">
                        <label for="kata_laluan"><strong>Kata Laluan</strong></label>
                        <input class="form-control" type="password" name="kata_laluan" placeholder="Kata Laluan" required>
                        @error('kata_laluan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="d-flex justify-content-between mt-4">
                    <!-- Back button aligned to the start -->
                    <div class="d-flex justify-content-start">
                        <a href="{{ route('auth.login')}}" class="btn btn-secondary" style="width: 120px">Balik</a>
                    </div>
                
                    <!-- Daftar and Reset buttons aligned to the end -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary mr-3" type="submit" style="width: 120px; background: rgba(33, 151, 225, 1);">Daftar</button>
                        <button class="btn btn-reset" type="reset" style="width: 120px;">Reset</button>
                    </div>
                </div>
                
            </form>
                      
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resetButton = document.querySelector('.btn-reset');

        resetButton.addEventListener('click', function () {
            document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(function(input) {
                input.value = ''; // Clear the input value
            });

            document.querySelectorAll('.text-danger').forEach(function(error) {
                error.innerHTML = ''; // Clear error messages
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bahagianSelect = document.getElementById('bahagian_id');
        const roleSelect = document.getElementById('role');
    
        // Listen for changes on the bahagian_id dropdown
        bahagianSelect.addEventListener('change', function () {
            const selectedBahagianId = bahagianSelect.value;
    
            // Clear the current options in the role dropdown
            roleSelect.innerHTML = '<option value="" disabled selected>Sila Pilih</option>';
    
            // Fetch roles based on the selected bahagian_id
            if (selectedBahagianId) {
                fetch(`/get-roles-by-bahagian/${selectedBahagianId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.roles && data.roles.length > 0) {
                            // Populate the role dropdown with the returned roles
                            data.roles.forEach(function(role) {
                                const option = document.createElement('option');
                                option.value = role.name;  // Using role name for value
                                option.textContent = role.name;  // Display role name in the dropdown
                                roleSelect.appendChild(option);
                            });
                        } else {
                            // If no roles are found, show a message
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No Roles Available';
                            roleSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching roles:', error);
                    });
            }
        });
    });
    </script>
    
@endsection

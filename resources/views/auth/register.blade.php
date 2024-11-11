@extends('layout.master-mini')

@section('content')

<div class="login-dark">
    <div class="container-fluid">
        <div class="form-container" style="width: 100%; max-width: 1080px;">
            <div class="d-flex justify-content-center mb-2">
                <img src="{{ asset('images/login-kkdw-logo.png') }}" alt="kkdw logo">
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
                        <input class="form-control" type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Penuh" required>
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
                        <label for="bahagian"><strong>Bahagian / Agensi / Institusi</strong></label>
                        <input class="form-control" type="text" name="bahagian" value="{{ old('bahagian') }}" placeholder="Bahagian / Agensi / Institusi" required>
                        @error('bahagian')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="form-row mb-3">
                    <!-- Jawatan Row -->
                    <div class="form-group col-md-4">
                        <label for="jawatan"><strong>Jawatan</strong></label>
                        <input class="form-control" type="text" name="jawatan" value="{{ old('jawatan') }}" placeholder="Jawatan" required>
                        @error('jawatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="emel"><strong>Alamat E-mel Rasmi</strong></label>
                        <input class="form-control" type="email" name="emel" value="{{ old('emel') }}" placeholder="Alamat E-mel Rasmi" required>
                        @error('emel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="no_tel"><strong>No. Telefon</strong></label>
                        <input class="form-control" type="text" name="no_tel" value="{{ old('no_tel') }}" placeholder="No. Telefon" required>
                        @error('no_tel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="form-row mb-4">
                    <!-- Kata Laluan Row -->
                    <div class="form-group col-md-4">
                        <label for="kata_laluan"><strong>Kata Laluan</strong></label>
                        <input class="form-control" type="password" name="kata_laluan" placeholder="Kata Laluan" required>
                        @error('kata_laluan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-primary mr-3" type="submit">Daftar</button>
                    <button class="btn btn-reset" type="reset">Reset</button>
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
@endsection

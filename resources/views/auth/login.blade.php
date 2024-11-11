@extends('layout.master-mini')

@section('content')
<div class="login-dark">
    <div class="form-container">
        <div class="d-flex justify-content-center mb-2">
            <img src="{{ asset('images/login-kkdw-logo.png') }}" alt="kkdw logo">
        </div>
        <form method="post" action="{{ route('auth.login_process') }}">
            @csrf
            <div class="text-center mb-5">
                <!-- Display General Error Messages -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                <h5><strong>SELAMAT DATANG KE DASHBOARD EKSEKUTIF KKDW</strong></h5>
            </div>
            <!-- ID Pengguna Row -->
            <div class="form-group row align-items-center">
                <label for="kad_pengenalan" class="col-sm-3 col-form-label"><strong>ID Pengguna</strong></label>
                <div class="col-sm-9">
                    <input class="form-control @error('kad_pengenalan') is-invalid @enderror" type="text" name="kad_pengenalan" placeholder="Kad Pengenalan" value="{{ old('kad_pengenalan') }}">
                    @error('kad_pengenalan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kata Laluan Row -->
            <div class="form-group row align-items-center">
                <label for="kata_laluan" class="col-sm-3 col-form-label"><strong>Kata Laluan</strong></label>
                <div class="col-sm-9">
                    <input class="form-control @error('kata_laluan') is-invalid @enderror" type="password" name="kata_laluan" placeholder="**********" value="{{ old('kata_laluan') }}">
                    @error('kata_laluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mr-4">
                    <a href="{{ route('auth.register') }}">Pendaftaran Baharu</a>
                </div>
                <div class="mr-4">
                    <a href="">Lupa Kata Laluan</a>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button class="btn btn-primary mr-3" type="submit">Log Masuk</button>
                <button class="btn btn-reset" type="button" onclick="resetForm()">Reset</button>
            </div>
        </form>
    </div>
</div>

<script>
    function resetForm() {
        // Clear the input fields
        document.querySelector('input[name="kad_pengenalan"]').value = '';
        document.querySelector('input[name="kata_laluan"]').value = '';
    }
</script>
@endsection

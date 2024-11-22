@extends('layout.master-mini')

@section('content')
<div class="login-dark">
    <div class="form-container">
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/jata-negara.png') }}" 
                 alt="jata negara logo" 
                 class="logo-image"
                 style="width: 198px; height: 138px; transform: translateY(50px) translateX(24px);"> <!-- Adjust width as needed -->
                 <img src="{{ asset('images/dashboard-eksekutif2.svg') }}" 
                 alt="dashboard eksekutif logo" 
                 class="logo-image"
                 style="width: 302px; height: 279px; transform: translateY(78px) translateX(42px);"> <!-- Adjust width as needed -->
        </div>      
        <form method="post" action="{{ route('auth.login_process') }}">
            <!-- Display General Error Messages -->
            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            @if (session()->has('status'))
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
            @endif
            @csrf
            <div class="text-center mb-5 mt-3">
                <!-- Display General Error Messages -->
                @if (session('faillogin'))
                    <div class="alert alert-danger">
                        {{ session('faillogin') }}
                    </div>
                @endif
                <h2><strong>LOG MASUK</strong></h2>
            </div>
        
            <!-- ID Pengguna Row -->
            <div class="form-group row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-10"> <!-- Increased column width here -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- Custom Icon as Background -->
                            <span class="input-group-text" style="background-color: white; border: 1px solid #ccc;">
                                <img src="{{ asset('images/user.png') }}" alt="Custom Icon" style="width: 20px; height: 20px;">
                            </span>
                        </div>
                        <input class="form-control @error('kad_pengenalan') is-invalid @enderror" type="text" name="kad_pengenalan" placeholder="ID Pengguna" value="{{ old('kad_pengenalan') }}">
                    </div>
                    @error('kad_pengenalan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Kata Laluan Row -->
            <div class="form-group row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-10"> <!-- Increased column width here -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- Custom Icon for Password -->
                            <span class="input-group-text" style="background-color: white; border: 1px solid #ccc;">
                                <img src="{{ asset('images/lock.png') }}" alt="Password Icon" style="width: 20px; height: 20px;">
                            </span>
                        </div>
                        <input class="form-control @error('kata_laluan') is-invalid @enderror" type="password" name="kata_laluan" placeholder="Kata Laluan" value="{{ old('kata_laluan') }}">
                    </div>
                    @error('kata_laluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
        
            
        
            <div class="d-flex justify-content-center mt-4">
                <button class="btn btn-primary mr-3" type="submit" style="width: 135px; background: rgba(33, 151, 225, 1);
                    ">Log Masuk
                </button>
                <button class="btn btn-reset" type="button" onclick="resetForm()" style="width: 135px">Reset</button>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('auth.register') }}" class="d-flex align-items-center mr-3" style="font-size: 14px;">
                    <img src="{{ asset('images/pendaftaranBaharu.png') }}" alt="Custom Icon" style="width: 18px; height: 18px; margin-right: 8px;">
                    Pendaftaran Baharu
                </a>
                <a href="{{ route('password.request') }}" style="font-size: 14px; margin-right: 34px">Lupa Kata Laluan</a>
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

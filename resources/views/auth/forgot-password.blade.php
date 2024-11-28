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
        <form method="post" action="{{ route('password.email') }}">
            @csrf
            <div class="text-center mb-5 mt-3">
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
                <h2><strong>Lupa Kata Laluan</strong></h2>
                <p>
                    Terlupa kata laluan anda? Anda perlu melengkapkan 
                    <br />
                    maklumat di bawah untuk menetapkan kata laluan baru.
                  </p>
                  
            </div>

            <!-- Kad Pengenalan Row -->
            <div class="form-group row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: white; border: 1px solid #ccc;">
                                <img src="{{ asset('images/user.png') }}" alt="Custom Icon" style="width: 20px; height: 20px;">
                            </span>
                        </div>
                        <input class="form-control" type="text" name="kad_pengenalan" placeholder="Kad Pengenalan">
                    </div>
                </div>
            </div>
        
            <!-- Email Row -->
            <div class="form-group row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-10"> <!-- Increased column width here -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- Custom Icon as Background -->
                            <span class="input-group-text" style="background-color: white; border: 1px solid #ccc;">
                                <img src="{{ asset('images/email.png') }}" alt="Custom Icon" style="width: 20px; height: 20px;">
                            </span>
                        </div>
                        <input class="form-control" type="email" name="email" placeholder="Emel">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('auth.login') }}" style="width: 146px" class="btn btn-secondary mr-3">Kembali</a>
                <button class="btn btn-primary" type="submit" style="width: 146px; background: rgba(33, 151, 225, 1);
                    ">Reset Kata Laluan
                </button>
            </div>
        </form>
        
        
    </div>
</div>

@endsection

@extends('layout.master')

<style>
    .label-column {
    font-family: 'Open Sans', sans-serif;
    font-weight: 600;
}

form .btn {
    box-shadow:3px 3px 4px rgba(0,0,0,0.25);
    width: 8%;
    text-shadow:none;
    outline:none;
  }

form .btn-primary {
    background: rgba(35, 44, 108, 1);
    border:none;
    border-radius:4px;
  }

form .btn-reset {
    border: 1px solid rgba(211, 211, 211, 1);
    border:none;
    border-radius:4px;
  }
  input[readonly].form-control {
    background-color: rgba(217, 217, 217, 1); /* Light grey */
    cursor: not-allowed; /* Indicate that the input is not editable */
}

</style>

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    


<div class="container-fluid d-flex justify-content-center">
    <div class="card mt-4 mx-auto" style="width: 90%;">
        <div class="card-header d-flex align-items-center custom-card-header" style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
            <img src="{{ asset('images/user-information.svg') }}" alt="Profile Icon" class="me-2" style="width: 24px; height: 24px;">
            Maklumat Profil
        </div>
        <div class="card-body">
            <form method="post" action="{{route('administration.update_pengguna', $userProfile->id)}}" id="" class="m-3">
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
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $userProfile->roles->first()->id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-md-3 label-column">Kad Pengenalan</div>
                    <div class="col-md-3">
                        <input readonly class="form-control" name="kad_pengenalan" value="{{ $userProfile->kad_pengenalan }}">
                    </div>
                    <div class="col-md-3 label-column">Alamat e-mel rasmi</div>
                    <div class="col-md-3">
                        <input readonly class="form-control" name="emel" value="{{ $userProfile->emel }}">
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-md-3 label-column">Bahagian/Agensi/Institusi</div>
                    <div class="col-md-3">
                        <input readonly class="form-control" name="bahagian" value="{{ $userProfile->bahagian }}">
                    </div>
                    <div class="col-md-3 label-column">No Telefon</div>
                    <div class="col-md-3">
                        <input class="form-control" name="no_tel" value="{{ $userProfile->no_tel }}">
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-md-3 label-column">Jawatan</div>
                    <div class="col-md-3">
                        <input readonly class="form-control" name="jawatan" value="{{ $userProfile->jawatan }}">
                    </div>
                    <div class="col-md-3 label-column">Status</div>
                    <div class="col-md-3">
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" {{ $userProfile->status == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="2" {{ $userProfile->status == '2' ? 'selected' : '' }}>Tidak Aktif</option>
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


    
    


@endsection
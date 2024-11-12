@extends('layout.master')

<style>
    .label-column {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
    }

    form .btn {
        box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.25);
        width: auto; /* Increase button width */
        text-shadow: none;
        outline: none;
        padding: 0.3rem 0.5rem; /* Adjust padding for shorter height */
    }

    form .btn-danger {
        border: 1px solid rgba(211, 211, 211, 1);
        border: none;
        border-radius: 4px;
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
            Senarai Pengguna Menunggu Kelulusan
        </div>
        <div class="card-body">
            <form method="post" action="" id="" class="d-flex flex-column h-100">
                @csrf
                <table id="penggunaTable1" class="table">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kad Pengenalan</th>
                        <th scope="col">Bahagian/Agensi/Institusi</th>
                        <th scope="col">Jawatan</th>
                        <th scope="col">Peranan</th>
                        <th scope="col">Emel</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($pengguna_belum_berdaftar as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->kad_pengenalan }}</td>
                            <td>{{ $user->bahagian }}</td>
                            <td>{{ $user->jawatan }}</td>
                            <td>{{ $user->roles->first()->name ?? 'Peranan Belum Ditetapkan' }}</td>
                            <td>{{ $user->emel }}</td>
                            <td>
                                @if($user->status === "0")
                                    <span class="text-warning">menunggu keputusan</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" type="button">Tindakan</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>        
    </div>
</div>

<div class="container-fluid d-flex justify-content-center">
    <div class="card mt-4 mx-auto" style="width: 90%;">
        <div class="card-header d-flex align-items-center custom-card-header" style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
            Pengurusan Pengguna > Pengguna
        </div>
        <div class="card-body">
            <form method="post" action="" id="" class="d-flex flex-column h-100">
                @csrf
                <table id="penggunaTable2" class="table">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kad Pengenalan</th>
                        <th scope="col">Bahagian/Agensi/Institusi</th>
                        <th scope="col">Jawatan</th>
                        <th scope="col">Peranan</th>
                        {{-- <th scope="col">Peranan</th> --}}
                        <th scope="col">Emel</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($senaraiPengguna as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->kad_pengenalan }}</td>
                            <td>{{ $user->bahagian }}</td>
                            <td>{{ $user->jawatan }}</td>
                            <td>{{ $user->roles->first()->name ?? 'Peranan Belum Ditetapkan' }}</td>
                            {{-- <td>{{ $user->Peranan->peranan }}</td> --}}
                            <td>{{ $user->emel }}</td>
                            <td>
                                @if($user->status === "1")
                                    <span class="text-success">Aktif</span>
                                @elseif($user->status === "2")
                                    <span class="text-danger">Tidak Aktif</span>
                                @else
                                    <span class="text-muted">Unknown Status</span> <!-- Optional: handle other statuses -->
                                @endif
                            </td>                            
                            <td>
                                <button class="btn btn-primary btn-sm" type="button">Tindakan</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>        
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable for penggunaTable2 only
    $('#penggunaTable2').DataTable({
        dom: "<'row'<'col-sm-4 d-flex justify-content-start'f><'col-sm-4 d-flex justify-content-start custom-filters'><'col-sm-4 d-flex justify-content-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +                             
             "<'row'<'col-sm-6 mt-2'l><'col-sm-6'p>>",
        buttons: [
            {
                text: '+ Tambah pengguna',
                action: function () {
                    // Redirect to the 'tambah-pengguna' route using Laravel's named route
                    window.location.href = '{{ route("administration.tambah_pengguna") }}'; 
                },
                className: 'btn btn-primary' // Add Bootstrap class for styling the button
            }
        ],
        initComplete: function () {
            // Add dropdowns for 'Peranan' and 'Bahagian' filtering
            var perananDropdown2 = $('<select class="form-select me-2"><option value="">Peranan</option></select>');
            var bahagianDropdown2 = $('<select class="form-select"><option value="">Bahagian</option></select>');

            // Populate options dynamically (optional)
            var perananOptions2 = [...new Set($('#penggunaTable2 tbody tr').map(function() {
                return $(this).find('td:nth-child(6)').text();
            }).get())];

            var bahagianOptions2 = [...new Set($('#penggunaTable2 tbody tr').map(function() {
                return $(this).find('td:nth-child(4)').text();
            }).get())];

            perananOptions2.forEach(option => perananDropdown2.append('<option value="'+option+'">'+option+'</option>'));
            bahagianOptions2.forEach(option => bahagianDropdown2.append('<option value="'+option+'">'+option+'</option>'));

            // Append dropdowns to custom-filters div
            $('.custom-filters').append(perananDropdown2).append(bahagianDropdown2);

            // Apply slight left margin adjustment
            $('.custom-filters').css('margin-left', '-163px'); // Adjust this value as needed

            // Adjust button position (move slightly to the right)
            $('.dt-buttons').css('margin-right', '-40%'); // Move the button to the right a bit

            // Event listeners for filtering
            perananDropdown2.on('change', function () {
                var searchTerm = $(this).val();
                $('#penggunaTable2').DataTable().column(5).search(searchTerm).draw();
            });

            bahagianDropdown2.on('change', function () {
                var searchTerm = $(this).val();
                $('#penggunaTable2').DataTable().column(3).search(searchTerm).draw();
            });
        }
    });
});
</script>










@endsection

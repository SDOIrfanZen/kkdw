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

<div class="container-fluid d-flex justify-content-center">
    <div class="card mt-4 mx-auto" style="width: 90%;">
        <div class="card-header d-flex align-items-center custom-card-header" style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
            Pengurusan Pengguna > Pengguna
        </div>
        <div class="card-body">
            <form method="post" action="" id="" class="d-flex flex-column h-100">
                @csrf
                <table id="penggunaTable2" class="table mt-3">
                    <thead>
                      <tr style="background: rgba(222, 225, 230, 1);">
                        <th scope="col">No.</th>
                        <th scope="col">Aktiviti</th>
                        <th scope="col">Nama Pengguna</th>
                        <th scope="col">Alamat IP</th>
                        <th scope="col">Tarikh</th>
                        <th scope="col">Masa</th>
                      </tr>
                    </thead>
                    <tbody>
                        <td>1</td>
                        <td>https://dashboardanalisadatakkdw.gov.my/dashboardutama/prestasiperbelanjaannegerikedah</td>
                        <td>Fatimah Binti Sidek</td>
                        <td>127.0.0.1</td>
                        <td>2024-04-12 </td>
                        <td>16:37</td>
                    </tbody>
                </table>
            </form>
        </div>        
    </div>
</div>











@endsection

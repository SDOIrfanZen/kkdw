@extends('layout.master')

@section('content')

<div class="container-fluid d-flex justify-content-center">
    <div class="card mt-4 mx-auto" style="width: 90%; border-radius: 8px;">
        <div class="card-header d-flex align-items-center custom-card-header" style="background: rgba(8, 12, 85, 1); height: 3.5rem;">
            <i class="fas fa-users-cog mr-2"></i> Pengurusan Pengguna > Peranan
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h4><strong>SENARAI PERANAN</strong></h4>
            </div>
            <table id="rolesTable" class="table">
                <thead class="thead-dark">
                    <tr style="background: rgba(222, 225, 230, 1);">
                        <th>No</th>
                        <th>Peranan</th>
                        <th>Pengguna</th>
                        <th>Capaian</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if($role->users->isNotEmpty())
                                {{ $role->users->count() }}
                            @else
                                Tiada pengguna
                            @endif
                        </td>
                        <td>
                            @if($role->permissions->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($role->permissions as $permission)
                                        <li><i class="fas fa-check-circle"></i> {{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Tiada capaian
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{route('administration.kemaskini_peranan', $role->id)}}" class="d-flex justify-content-center align-items-center" style="padding-top: 12%; height: 100%">
                                <img src="{{ asset('images/tindakan.svg') }}" alt="Tindakan Icon" width="18" height="18" style="cursor: pointer;">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#rolesTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "ordering": true, // Enable column sorting
            "info": true, // Show info about the number of rows
            "lengthChange": true, // Allow the user to change the number of rows per page
            "responsive": true, // Enable responsive design
        });

        // Move the search box to the top right corner
        $('.dataTables_filter').css({
            'position': 'absolute',
            'top': '13px', // Create 20px gap between search box and top of the table
            'left': '1px', // Move it to the top-right
            'margin-bottom': '10px', // Additional gap to avoid overlap with table
        });

        // Ensure the table's border is visible by adjusting its wrapper's margin or padding
        $('#rolesTable').css({
            'border-top': '2px solid #ccc' // Restore the border-top of the table
        });

        // Add some spacing to table cells for readability
        $('#rolesTable th, #rolesTable td').css({
            'border-right': 'none',  // Remove right border of each column
            'border-left': 'none',   // Remove left border of each column
            'border-top': '1px solid #ccc',  // Optional: add horizontal border between rows
            'border-bottom': '1px solid #ccc', // Optional: add horizontal border between rows
            'padding': '10px', // Spacing for readability
        });

        // Move the "Show entries" dropdown to the bottom left
        $('.dataTables_length').css({
            'position': 'absolute',
            'bottom': '75px',  // Move Show entries to just above the pagination
            'left': '0px',
        });

        // Move the pagination information to the bottom
        $('.dataTables_info').css({
            'position': 'absolute',
            'bottom': '44px', // Position the pagination text below the Show entries dropdown
            'left': '0px',
        });

        // Add custom spacing for better visibility
        $('.dataTables_wrapper').css({
            'position': 'relative',
            'padding-top': '60px',  // Space for the search box to avoid overlap
            'padding-bottom': '70px',  // Space for both the Show entries dropdown and pagination text
        });
    });
</script>


@endsection


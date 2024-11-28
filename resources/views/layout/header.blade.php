<!-- Meta and Title -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>KKDW</title>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
<!-- Core theme CSS (includes Bootstrap) -->
<link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>


<style>
    .custom-small-text {
        font-size: 0.75rem;
        /* Adjust the size as needed */
    }
</style>

<!-- Header: Welcome message and navbar -->
<header>
    <!-- Line and Welcome Message above navbar -->
    <div class="bg-primary text-white text-end py-1 fixed-top"
        style="background: linear-gradient(90deg, #0B1A93 0%, #03082D 100%);">
        <h6 class="mb-0 me-5 custom-small-text"> <!-- Use custom class here -->
            Selamat Datang {{ Auth::user()->nama }}
        </h6> <!-- Welcome message -->
    </div>

    <!-- Responsive navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top" style="top: 1.4rem;">
        <div class="container-fluid d-flex justify-content-between">

            <!-- Left Section (Logo) -->
            <div class="d-flex justify-content-start">
                <a class="nav-link me-5" href="#!">
                    <img src="{{ asset('images/kkdw-logo.svg') }}" alt="Laman Utama" class="nav-icon"
                        style="width: 100px">
                </a>
            </div>

            <!-- Center Section (Nav Links) -->
            <div class="d-flex justify-content-center">
                <ul class="navbar-nav mb-2 mb-lg-0 d-flex">
                    <li class="nav-item">
                        @if (Gate::any(['Dashboard Utama']))
                        <a class="nav-link" href="#!">
                            <img src="{{ asset('images/laman-utama.svg') }}" alt="Laman Utama" class="nav-icon"> Laman
                            Utama
                        </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Gate::any([
                                'Prestasi Perbelanjaan Negeri',
                                'Dashboard Infrastruktur Asas & Laporan',
                                'Dashboard Ekonomi & Laporan',
                                'Dashboard Modal Insan & Laporan',
                                'Dashboard Usahawan',
                                'Dashboard Profil Kampung',
                            ]))
                            <a class="nav-link" href="{{ route('administration.dashboard') }}">
                                <img src="{{ asset('images/dashboard.svg') }}" alt="Dashboard" class="nav-icon">
                                Dashboard
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Gate::any([
                                'Prestasi Perbelanjaan Bahagian PP',
                                'Prestasi Perbelanjaan Bahagian PRA',
                                'Prestasi Perbelanjaan Bahagian K',
                                'Prestasi Perbelanjaan Bahagian KR',
                                'Prestasi Perbelanjaan Bahagian EK',
                                'Prestasi Perbelanjaan Bahagian KD',
                                'Prestasi Perbelanjaan Bahagian INFRA',
                                'Prestasi Perbelanjaan Bahagian TW',
                                'Prestasi Perbelanjaan Bahagian UD',
                            ]))
                        <a class="nav-link" href="#!">
                            <img src="{{ asset('images/prestasi-perbelanjaan-bahagian.svg') }}"
                                alt="Prestasi Perbelanjaan Bahagian" class="nav-icon"> Prestasi Perbelanjaan Bahagian
                        </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Gate::any(['Muat Naik Data', 'Purata Nasional', 'Unjuran']))
                        <a class="nav-link" href="{{ route('administration.pengurusan_pengguna_data') }}">
                            <img src="{{ asset('images/pengurusan-data.svg') }}" alt="Pengurusan Data" class="nav-icon">
                            Pengurusan Data
                        </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Gate::any([
                                'Melihat Senarai Pengguna',
                                'Melihat Senarai Peranan',
                            ]))
                            <a class="nav-link" href="{{ route('administration.pengurusan_pengguna_main') }}">
                                <img src="{{ asset('images/pengurusan-pengguna.svg') }}" alt="Pengurusan Pengguna"
                                    class="nav-icon"> Pengurusan Pengguna
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Gate::any([
                                'Papar Senarai Log',
                                'Carian Log (hari atau pengguna)',
                                'Export Excel/PDF',
                            ]))
                        <a class="nav-link" href="#!">
                            <img src="{{ asset('images/audit-trail.svg') }}" alt="Audit Trail" class="nav-icon"> Audit
                            Trail
                        </a>
                        @endif
                    </li>
                </ul>
            </div>

            <!-- Right Section (Profile Dropdown) -->
            <div class="d-flex justify-content-end">
                <div class="nav-item dropdown ms-5">
                    <a class="nav-link dropdown-toggle fs-5" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="img-xs rounded-circle" src="{{ asset('images/example-profile-picture.svg') }}"
                            alt="Default Profile Image" width="60%">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @can('Papar Maklumat Profil Pengguna')
                        <li><a class="dropdown-item" href="{{ route('administration.manage_account') }}">Lihat Profil</a></li>
                        @endcan
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</header>

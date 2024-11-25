@extends('layout.master')

@section('content')

<style>
    /* Parent container styles */
    .centered-content {
        display: flex;
        flex-wrap: wrap; /* Allow the images to wrap to the next line */
        justify-content: center; /* Center the images horizontally */
        align-items: center; /* Center the images vertically */
        min-height: calc(100vh - 7rem - 5rem); /* Adjust the container height */
        padding: 20px; /* Add padding to prevent the images from touching the edges */
    }

    .image-size {
        height: 440px;
        margin: 20px; /* Adjust margin for spacing between images */
        max-width: 100%; /* Ensure the image scales appropriately */
    }

    /* Ensure the <a> tag only takes the size of the image */
    .image-link {
        display: block; /* Make the <a> tag block-level */
        text-decoration: none; /* Remove underline */
    }
    
    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .image-size {
            height: 300px; /* Reduce image size on smaller screens */
        }
    }

    @media (max-width: 576px) {
        .image-size {
            height: 200px; /* Further reduce image size on extra small screens */
        }
    }
</style>

<div class="container-fluid centered-content">
    <!-- Image links centered in the middle -->
    @can('Dashboard Infrastruktur Asas & Laporan')
    <a href="#" class="image-link">
        <img src="{{ asset('images/d-infrastruktur.png') }}" alt="Image 1" class="img-fluid image-size">
    </a>
    @endcan
    @can('Dashboard Ekonomi & Laporan')
    <a href="#" class="image-link">
        <img src="{{ asset('images/d-ekonomi.png') }}" alt="Image 2" class="img-fluid image-size">
    </a>
    @endcan
    @can('Dashboard Modal Insan & Laporan')
    <a href="#" class="image-link">
        <img src="{{ asset('images/d-modal-insan.png') }}" alt="Image 3" class="img-fluid image-size">
    </a>
    @endcan
    @can('Dashboard Usahawan')
    <a href="#" class="image-link">
        <img src="{{ asset('images/d-usahawan.png') }}" alt="Image 4" class="img-fluid image-size">
    </a>
    @endcan
    @can('Dashboard Profil Kampung')
    <a href="#" class="image-link">
        <img src="{{ asset('images/d-profil-kampung.png') }}" alt="Image 5" class="img-fluid image-size">
    </a>
    @endcan
</div>

@endsection

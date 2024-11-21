@extends('layout.master')

@section('content')

<style>
    /* Parent container styles */
    .centered-content {
        display: flex;
        justify-content: center; /* Horizontal centering */
        align-items: center; /* Vertical centering */
        min-height: calc(100vh - 7rem - 5rem); /* Calculate available height */
    }

    .image-size {
        height: 440px;
        margin: 0 20px; /* Adjust margin for spacing between images */
    }

    /* Ensure the <a> tag only takes the size of the image */
    .image-link {
        display: block; /* Make the <a> tag block-level */
        text-decoration: none; /* Remove underline */
    }
</style>

<div class="container-fluid centered-content">
    <!-- Image links centered in the middle -->
    <a href="{{ route('administration.pengurusan_pengguna') }}" class="image-link">
        <img src="{{ asset('images/pengguna-card.png') }}" alt="Image 1" class="img-fluid image-size">
    </a>
    <a href="#" class="image-link">
        <img src="{{ asset('images/peranan-card.png') }}" alt="Image 2" class="img-fluid image-size">
    </a>
    <a href="#" class="image-link">
        <img src="{{ asset('images/capaian-card.png') }}" alt="Image 3" class="img-fluid image-size">
    </a>
</div>

@endsection

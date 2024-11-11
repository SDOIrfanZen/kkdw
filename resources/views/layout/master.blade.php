<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layout.header')
    </head>
    <body style="padding-top: 7rem; padding-bottom: 7rem">
        <!-- Page Content-->
        <div class="container-fluid px-4 px-lg-5">
            @yield('content')
        </div>
        
        @include('layout.footer')
    </body>
</html>

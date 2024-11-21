<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layout.header')
    </head>
    <body style="display: flex; flex-direction: column; min-height: 100vh; margin: 0;">
        <!-- Header -->
        @include('layout.header')

        <!-- Page Content -->
        <main style="flex: 1; padding-top: 7rem; padding-bottom: 5rem;">
            <div>
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        @include('layout.footer')
    </body>
</html>

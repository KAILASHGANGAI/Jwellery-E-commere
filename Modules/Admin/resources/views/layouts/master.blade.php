<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin Module - {{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $author ?? '' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    {{-- Vite CSS --}}
    {{-- {{ module_vite('build-admin', 'resources/assets/sass/app.scss') }} --}}
</head>
@yield('style')
<body>

    <div class="hamburger" onclick="toggleSidebar()">☰</div>
    <div class="mycontainer">
        @include('admin::includes.navbar')
        <div class="main-content">
         @include('admin::includes.sidebar')
                   
         @yield('content')
        </div>
    </div>
    <script>
          function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        function toggleDropdown(element) {
            element.classList.toggle('active');
        }

        function toggleFilter() {
            document.getElementById("filterDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.filter-dropdown span')) {
                var dropdowns = document.getElementsByClassName("filter-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    @yield('script')
</body>

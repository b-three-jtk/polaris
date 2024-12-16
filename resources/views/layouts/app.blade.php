<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/Logo-mini.png') }}" type="image/x-icon" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    <header>
        @include('components.navbar')
    </header>

    <div class="mx-auto overflow-hidden pt-20">
        @yield('content')
    </div>

    @include('components.footer')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function navToogle() {
            var x = document.getElementById("nav-items");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        window.onscroll = function() {
            myFunction()
        };

        var navlist = document.querySelector("#nav-list");
        var sticky = navlist.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navlist.classList.add("sticky")
            } else {
                navlist.classList.remove("sticky");
            }
        }
    </script>
</body>

</html>

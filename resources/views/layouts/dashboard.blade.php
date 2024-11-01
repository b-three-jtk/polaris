<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/Logo-mini.png') }}" type="image/x-icon"/>
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body>
    <header>
        @include('components.navbar_dashboard')
    </header>

    <div class="content">
        @yield('content')
    </div>

    @include('components.footer_dashboard')
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
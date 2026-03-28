<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') | POS System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/fontawesome.css') }}">
    @stack('css')
</head>

<body>
    @include('backend.layouts.partials.sidebar')
    @include('backend.layouts.header')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('backend/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pcoded.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('backend/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>

    @include('backend.layouts.partials.sidebar')
    @include('backend.layouts.partials.header')

    <div class="pc-container">
        <div class="pc-content">
            <div id="pc-layout-config" style="display:none;"></div>
            <div id="pc-sidebar-caption" style="display:none;"></div>
            <div id="pc-layout-font" style="display:none;"></div>

            @yield('content')
        </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row text-center">
                <div class="col-sm my-1">
                    <p class="m-0">© {{ date('Y') }} {{ config('app.name') }}</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('backend/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pcoded.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // 1. Kill all JS errors 
        window.onerror = function() { return true; };

        $(document).ready(function() {
            // 2. Force Redirect Bypass (In case theme blocks it)
            $(document).on('click', '.pc-link, .pc-link-fixed', function (e) {
                var targetUrl = $(this).attr('href');
                if (targetUrl && targetUrl !== '#' && targetUrl !== '#!') {
                    // Agar link standard redirect nahi kar raha, toh manually bhejo
                    window.location.href = targetUrl;
                }
            });

            // 3. Icons refresh
            if (typeof feather !== 'undefined') { feather.replace(); }
        });
    </script>

    @stack('scripts')
</body>
</html>
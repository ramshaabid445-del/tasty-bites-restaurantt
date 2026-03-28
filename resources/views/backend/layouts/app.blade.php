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
    <style>
        :root {
            --primary-color: #7267ef;
            --secondary-color: #6c757d;
            --success-color: #2ca87f;
            --info-color: #3ebfea;
            --warning-color: #e58a00;
            --danger-color: #dc2626;
            --light-color: #f8f9fa;
            --dark-color: #1a1c23;
            --card-radius: 16px;
            --card-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
            --content-padding: 24px;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f4f7fa;
            color: #4b5563;
        }

        .pc-container {
            padding-top: 0;
            min-height: calc(100vh - 70px);
        }

        .pc-content {
            padding: var(--content-padding);
        }

        .page-header {
            margin-bottom: 2rem;
            background: transparent;
            padding: 0;
        }

        .page-header h2, .page-header h3, .page-header h4, .page-header h5 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.875rem;
        }

        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: var(--content-padding);
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }

        .card-header h5 {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: #5e54d3; border-color: #5e54d3; transform: translateY(-1px); }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.025em;
            padding: 1rem 1.5rem;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            color: #4b5563;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge {
            padding: 0.5em 0.8em;
            font-weight: 600;
            border-radius: 6px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(114, 103, 239, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #999; }

        @media (max-width: 1024px) {
            .pc-container { margin-left: 0; }
            .pc-content { padding: 1rem; }
        }
    </style>
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

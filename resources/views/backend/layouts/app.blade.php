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
        --content-padding: 24px;
    }

    /* --- THE GREY SCREEN KILLER (Nuclear Version) --- */
    /* Target strictly the overlay without affecting layout buttons */
    .pc-container::before, 
    .pc-container::after,
    body.pc-sidebar-hide .pc-container::before,
    .pc-sidebar-hide .pc-container::before,
    [data-pc-sidebar-caption="true"] .pc-container::before {
        display: none !important;
        content: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
        background: transparent !important;
    }

    /* Force background and remove any filters/blur */
    body, .pc-container, .pc-header, .pc-content {
        filter: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        background-color: #f4f7fa !important;
        opacity: 1 !important;
    }

    .card {
        background: #fff !important;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: var(--content-padding);
    }

    /* --- SIDEBAR & BUTTON FIXES --- */
    .pc-sidebar { transition: all 0.3s ease; }

    @media (max-width: 1024px) {
        /* Sidebar always hidden by default on mobile */
        .pc-sidebar {
            left: -280px !important;
            position: fixed !important;
            z-index: 2000 !important;
            visibility: visible !important;
            display: block !important;
        }
        /* When active, slide it in */
        .pc-sidebar.mob-sidebar-active {
            left: 0 !important;
        }
        /* IMPORTANT: Force the Hamburger button to stay visible */
        .pc-header .pc-h-item.pc-sidebar-collapse, 
        .pc-header .pc-head-link#sidebar-hide {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .pc-container { margin-left: 0 !important; width: 100% !important; }
    }

    /* Overlay for mobile when sidebar is open */
    .pc-menu-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1500;
        display: none;
    }
    .pc-menu-overlay.active { display: block; }

    /* ============================================= */
    /* ===========  DARK PURPLE SIDEBAR  ============ */
    /* ============================================= */

    .pc-sidebar {
        background: linear-gradient(180deg, #241b3e 0%, #1a1330 100%) !important;
        border-right: none;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
    }

    /* Logo area */
    .pc-sidebar .m-header {
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 16px;
    }

    .pc-sidebar .b-brand span,
    .pc-sidebar .b-brand .text-dark {
        color: #ffffff !important;
    }

    /* Caption labels (Core Operations, Management, etc.) */
    .pc-sidebar .pc-item.pc-caption label {
        color: rgba(255, 255, 255, 0.35) !important;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .pc-sidebar .pc-item.pc-caption i {
        color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Nav links */
    .pc-sidebar .pc-link {
        color: rgba(255, 255, 255, 0.65) !important;
        border-radius: 10px;
        margin: 2px 12px;
        padding: 10px 14px;
        transition: all 0.25s ease;
        position: relative;
    }

    .pc-sidebar .pc-micon i,
    .pc-sidebar .pc-micon svg {
        color: rgba(255, 255, 255, 0.5) !important;
        transition: color 0.25s ease;
    }

    .pc-sidebar .pc-arrow i {
        color: rgba(255, 255, 255, 0.35) !important;
    }

    /* Hover state */
    .pc-sidebar .pc-item:not(.pc-caption) > .pc-link:hover {
        background: rgba(114, 103, 239, 0.15) !important;
        color: #ffffff !important;
    }

    .pc-sidebar .pc-item:not(.pc-caption) > .pc-link:hover .pc-micon i {
        color: #a99bff !important;
    }

    /* Active / current page state */
    .pc-sidebar .pc-item.active > .pc-link,
    .pc-sidebar .pc-item.pc-trigger > .pc-link {
        background: linear-gradient(90deg, rgba(114, 103, 239, 0.9) 0%, rgba(114, 103, 239, 0.55) 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(114, 103, 239, 0.35);
    }

    .pc-sidebar .pc-item.active > .pc-link .pc-micon i,
    .pc-sidebar .pc-item.pc-trigger > .pc-link .pc-micon i {
        color: #ffffff !important;
    }

    /* Small accent bar on active item */
    .pc-sidebar .pc-item.active > .pc-link::before {
        content: '';
        position: absolute;
        left: -12px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: #ffffff;
        border-radius: 0 4px 4px 0;
        opacity: 0.9;
    }

    /* Submenu */
    .pc-sidebar .pc-submenu {
        background: rgba(0, 0, 0, 0.18) !important;
        border-radius: 10px;
        margin: 2px 12px 6px 12px;
        padding: 6px 0;
    }

    .pc-sidebar .pc-submenu .pc-link {
        margin: 1px 8px;
        padding: 8px 12px 8px 34px;
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.55) !important;
    }

    .pc-sidebar .pc-submenu .pc-link:hover {
        background: rgba(114, 103, 239, 0.2) !important;
        color: #ffffff !important;
    }

    .pc-sidebar .pc-submenu .pc-link i {
        color: rgba(255, 255, 255, 0.4) !important;
    }

    .pc-sidebar .pc-submenu .pc-link:hover i {
        color: #a99bff !important;
    }

    /* Custom scrollbar for sidebar */
    .pc-sidebar .navbar-content::-webkit-scrollbar {
        width: 5px;
    }
    .pc-sidebar .navbar-content::-webkit-scrollbar-track {
        background: transparent;
    }
    .pc-sidebar .navbar-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }
    .pc-sidebar .navbar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <div class="pc-menu-overlay"></div>
    
    @include('backend.layouts.partials.sidebar')
    @include('backend.layouts.partials.header')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    <footer class="pc-footer text-center py-3">
        <p class="m-0">© {{ date('Y') }} {{ config('app.name') }}</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('backend/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pcoded.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // Function to kill the grey shade and fix layout
        function killGreyShade() {
            // Remove the dark filter/backdrop
            $('.pc-container, body, .pc-header').css({
                'filter': 'none',
                'backdrop-filter': 'none',
                'background-color': '#f4f7fa'
            });
            // Ensure the toggle button exists and is visible
            if ($('#sidebar-hide').length > 0) {
                $('#sidebar-hide').show().css('visibility', 'visible');
            }
        }

        // Run every 100ms because the template JS keeps trying to re-add the shade
        setInterval(killGreyShade, 100);

        // Unified Toggle Logic
        $(document).on('click', '#sidebar-hide', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if ($(window).width() < 1025) {
                $('.pc-sidebar').toggleClass('mob-sidebar-active');
                $('.pc-menu-overlay').toggleClass('active');
            } else {
                $('body').toggleClass('pc-sidebar-hide');
            }
        });

        // Close on overlay click
        $('.pc-menu-overlay').on('click', function() {
            $('.pc-sidebar').removeClass('mob-sidebar-active');
            $(this).removeClass('active');
        });

        if (typeof feather !== 'undefined') { feather.replace(); }
    });
</script>

    @stack('scripts')
</body>
</html>
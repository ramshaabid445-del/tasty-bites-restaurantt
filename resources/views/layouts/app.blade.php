<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel')) | Restaurant POS</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @stack('styles') {{-- Extra CSS for specific pages --}}
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        
        <div class="min-h-screen flex">
            @include('layouts.sidebar') {{-- Isay create karna parega --}}

            <div class="flex-1 flex flex-col">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $header }}
                            </h2>
                            <div id="page_actions">
                                @yield('page-actions') {{-- Add buttons like '+ Add New' here --}}
                            </div>
                        </div>
                    </header>
                @endisset

                <main class="p-6">
                    {{ $slot }}
                </main>
                
                <footer class="mt-auto py-4 bg-white border-t border-gray-100 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </footer>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right" };
            @if(session('success')) toastr.success("{{ session('success') }}"); @endif
            @if(session('error')) toastr.error("{{ session('error') }}"); @endif
        </script>

        @stack('scripts') {{-- For page-specific JS like POS math --}}
    </body>
</html>
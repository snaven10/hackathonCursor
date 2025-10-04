<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <x-alert type="success" :message="session('success')" />
                </div>
            @endif
            
            @if (session('error'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <x-alert type="error" :message="session('error')" />
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600">
                        <p>&copy; {{ date('Y') }} 4Life. Todos los derechos reservados.</p>
                        <div class="flex space-x-4 mt-2 sm:mt-0">
                            <a href="#" class="hover:text-emerald-600 transition">Soporte</a>
                            <a href="#" class="hover:text-emerald-600 transition">Privacidad</a>
                            <a href="#" class="hover:text-emerald-600 transition">Términos</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>

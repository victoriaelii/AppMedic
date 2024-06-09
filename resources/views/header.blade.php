<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Estilos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
        }
        .custom-bg {
            background-color: #124A87;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header class="custom-bg shadow-md">
        <!-- Barra de navegación -->
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1 items-center">
                <!-- Enlace al inicio -->
                <a href="/" class="flex items-center">
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Health Center</span>
                </a>
            </div>
            <div class="lg:flex lg:gap-x-12">
                <div class="relative">
                    @if (Route::has('login'))
                        <div class="flex flex-1 justify-end">
                            @auth
                                <!-- Enlace al dashboard si el usuario está autenticado -->
                                <a href="{{ url('/dashboard') }}" class="text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 transition">
                                    Dashboard
                                </a>
                            @else
                                @if (Route::has('register'))
                                    <!-- Enlace para registrar si el usuario no está autenticado -->
                                    <a href="{{ route('register') }}" class="text-white underline hover:text-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultorio Médico</title>
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Estilo de fondo */
        .background {
            background-image: url('https://images.unsplash.com/photo-1548101307-a757d5f06d27?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        /* Estilo de la superposición */
        .overlay {
            background-color: rgba(0, 0, 0, 0.65);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        /* Estilo de los botones */
        .btn-custom {
            margin-top: 20px;
            color: white;
            border: 1px solid white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-custom:hover {
            color: black;
            background-color: white;
        }
    </style>
</head>
<body class="font-sans antialiased">
<!-- Contenedor principal con fondo y superposición -->
<div class="background flex items-center justify-center">
    <div class="overlay max-w-md w-full">
        <!-- Encabezado -->
        <header class="mb-6">
            <h1 class="text-4xl font-bold">Bienvenido a HealthCenter</h1>
            <p class="mt-2 text-lg">Cuidando de tu salud con profesionalismo y dedicación</p>
        </header>
        <!-- Botones de acción -->
        <div class="flex justify-center space-x-4 mb-6">
            @if (Route::has('login'))
                @auth
                    <!-- Enlace al dashboard si el usuario está autenticado -->
                    <a href="{{ url('/dashboard') }}" class="btn-custom">
                        Dashboard
                    </a>
                @else
                    <!-- Enlace para iniciar sesión si el usuario no está autenticado -->
                    <a href="{{ route('login') }}" class="btn-custom">
                        Iniciar sesión
                    </a>
                @endauth
            @endif
        </div>
        <!-- Pie de página -->
        <footer class="text-gray-300 text-sm">
            © 2024 HealthCenter. Todos los derechos reservados.
        </footer>
    </div>
</div>
</body>
</html>

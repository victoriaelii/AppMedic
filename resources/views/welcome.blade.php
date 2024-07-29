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
        body {
            background-color: #f8fafc;
            color: #333;
        }
        header, footer {
            background-color: #1f2937;
            color: white;
        }
        .team-member, .service {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .team-member:hover, .service:hover {
            transform: translateY(-5px);
        }
        .team-member img, .service img {
            border-radius: 10px 10px 0 0;
            object-fit: cover;
        }
        .button {
            border: 2px solid white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-transform: uppercase;
            font-weight: bold;
            color: white;
            background: transparent;
            transition: all 0.3s ease-in-out;
        }
        .button:hover, .button:focus {
            background-color: white;
            color: black;
            outline: none;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: #4A90E2; /* Color azul para hover */
        }
        .section-spacing {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
        .input-code {
            background-color: #1f2937;
            color: white;
            border: 2px solid white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }
    </style>
    <!-- SEO Meta Tags -->
    <meta name="description" content="HealthCenter: Cuidando de tu salud con profesionalismo y dedicación. Conoce a nuestro equipo y servicios.">
    <meta name="keywords" content="HealthCenter, salud, medicina, terapia, psiquiatría, asesoramiento, acupuntura">
    <meta name="author" content="HealthCenter">
</head>
<body class="font-sans antialiased">
    <!-- Header con navegación -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-gray-900 bg-opacity-25">
        <nav class="container mx-auto p-4 flex justify-between items-center">
            <div class="text-white font-bold text-2xl">HealthCenter</div>
            <div class="flex space-x-4">
                @if (Route::has('login'))
                    @auth
                        <!-- Enlace al dashboard si el usuario está autenticado -->
                        <a href="{{ url('/dashboard') }}" class="button">
                            Dashboard
                        </a>
                    @else
                        <!-- Enlace para iniciar sesión si el usuario no está autenticado -->
                        <a href="{{ route('login') }}" class="button">
                            Iniciar sesión
                        </a>
                        <!-- Campo para ingresar el código -->
                        <form action="{{ route('verificarCodigo') }}" method="POST" class="flex space-x-2">
                            @csrf
                            <input type="text" name="codigo" placeholder="Ingresa tu código" class="input-code" required>
                            <button type="submit" class="button">Verificar</button>
                        </form>
                    @endauth
                @endif
            </div>
        </nav>
    </header>
    <!-- Contenedor principal con fondo y superposición -->
    <div class="relative bg-cover bg-center h-screen" style="background-image: url('https://images.unsplash.com/photo-1548101307-a757d5f06d27?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <!-- Superposición de color -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50"></div>
        <!-- Contenido principal -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold mb-4">HealthCenter</h1>
            <p class="text-lg mb-8">Cuidando de tu salud con profesionalismo y dedicación</p>
            <!-- Iconos debajo del eslogan -->
            <div class="flex space-x-8">
                <div class="flex flex-col items-center">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/stethoscope.png" alt="Profesionales de salud">
                    <p class="mt-2">Profesionales de salud</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/clinic.png" alt="Instalaciones modernas">
                    <p class="mt-2">Instalaciones modernas</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/calendar.png" alt="Fácil agendamiento">
                    <p class="mt-2">Fácil agendamiento</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Sección "Nuestro enfoque" -->
    <section class="container mx-auto section-spacing">
        <h2 class="text-3xl font-bold text-center mb-8">Nuestro enfoque</h2>
        <p class="text-center max-w-2xl mx-auto">
            Somos un grupo de psicólogos y psiquiatras con doctorados y ofrecemos atención a la salud mental de alta calidad. Estamos especializados en salud mental y proporcionamos servicios de terapia, control de la medicación, asesoramiento psicológico y más. Te pondremos en contacto con uno de nuestros médicos según tus necesidades y su disponibilidad, ya sea en línea o en persona.
        </p>
    </section>
    <!-- Sección "Conoce a nuestro equipo" -->
    <section class="container mx-auto section-spacing">
        <h2 class="text-3xl font-bold text-center mb-8">Conoce a nuestro equipo</h2>
        <div class="flex justify-center space-x-8">
            <div class="team-member w-64">
                <img src="https://images.unsplash.com/photo-1651008376811-b90baee60c1f?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Victoria Juarez" class="w-full h-56 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-bold">Médico General</h3>
                    <p class="text-gray-600">Victoria Juarez</p>
                </div>
            </div>
            <div class="team-member w-64">
                <img src="https://images.unsplash.com/photo-1649642828190-d6f6f71702d6?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Elizabeth Morales" class="w-full h-56 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-bold">Recepcionista Lic.</h3>
                    <p class="text-gray-600">Elizabeth Morales</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Sección "Nuestros servicios" -->
    <section class="bg-gray-100 text-gray-800 section-spacing">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Nuestros servicios</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="service">
                    <img src="https://images.unsplash.com/photo-1616012481039-5de1dcb42934?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Radiografía" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Radiografía</h3>
                    </div>
                </div>
                <div class="service">
                    <img src="https://images.unsplash.com/photo-1706065264583-55f1a8549769?q=80&w=1471&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Ecografía (Ultrasonido)" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Ecografía (Ultrasonido)</h3>
                    </div>
                </div>
                <div class="service">
                    <img src="https://images.unsplash.com/photo-1578496479531-32e296d5c6e1?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Pruebas de Laboratorio" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Pruebas de Laboratorio</h3>
                    </div>
                </div>
                <div class="service">
                    <img src="https://images.unsplash.com/photo-1581090122319-8fab9528eaaa?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Terapia Física y Rehabilitación" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Terapia Física y Rehabilitación</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto text-center">
            <div class="social-icons mb-4">
                <a href="https://facebook.com" target="_blank" aria-label="Facebook"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/facebook-new.png" alt="Facebook"></a>
                <a href="https://twitter.com" target="_blank" aria-label="Twitter"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/twitter.png" alt="Twitter"></a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/instagram-new.png" alt="Instagram"></a>
                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/linkedin.png" alt="LinkedIn"></a>
            </div>
            <p>&copy; 2024 HealthCenter. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

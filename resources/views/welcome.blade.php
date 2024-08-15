@include("header")

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultorio Médico</title>
    <!-- Fuentes -->

    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
            color: #333;
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

        .section-spacing {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

    </style>
    <!-- SEO Meta Tags -->
    <meta name="description" content="HealthCenter: Cuidando de tu salud con profesionalismo y dedicación. Conoce a nuestro equipo y servicios.">
    <meta name="keywords" content="HealthCenter, salud, medicina, terapia, psiquiatría, asesoramiento, acupuntura">
    <meta name="author" content="HealthCenter">
</head>
<body class="font-poppins antialiased">
    <!-- Header con navegación -->

    <!-- Contenedor principal con fondo y superposición -->
    <div class="relative bg-cover bg-center h-screen" style="background-image: url('https://images.unsplash.com/photo-1548101307-a757d5f06d27?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <!-- Superposición de color -->
        <div class="absolute inset-0"></div>
        <!-- Contenido principal -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold mb-4">Health Center</h1>
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
            <!-- Formulario de ingreso de código -->
            <div class="mt-10">
                <form id="codigoForm" class="flex space-x-2">
                    @csrf
                    <input type="text" name="codigo" placeholder="Ingresa tu código" class="input-code bg-transparent border-2 border-white text-white px-4 py-2 rounded-md placeholder-white focus:ring-2 focus:ring-blue-500 transition" required>
                    <button type="submit" class="text-white hover:text-gray-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 50 50" fill="currentColor">
                            <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>

@include("footer")

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para manejar la verificación del código con AJAX -->
<script>
    $(document).ready(function() {
        $('#codigoForm').on('submit', function(e) {
            e.preventDefault(); 
            $.ajax({
                url: '{{ route('verificarCodigo') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message || 'Código inválido o sin citas finalizadas.',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });
</script>

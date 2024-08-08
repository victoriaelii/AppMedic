<header class="fixed top-0 left-0 right-0 z-50 bg-gray-900 bg-opacity-50 backdrop-blur-lg shadow-lg">
    <nav class="container mx-auto p-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-white font-bold text-2xl tracking-wide">HealthCenter</a>
        <div class="flex space-x-6 items-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white border-b-2 border-transparent hover:border-white transition">
                        Dashboard
                    </a>
                @else
                    <form id="codigoForm" class="flex space-x-2">
                        @csrf
                        <input type="text" name="codigo" placeholder="Ingresa tu código" class="input-code bg-transparent border-2 border-white text-white px-4 py-2 rounded-md placeholder-white focus:ring-2 focus:ring-blue-500 transition" required>
                        <button type="submit" class="text-white hover:text-gray-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 50 50" fill="currentColor">
                                <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
                            </svg>
                        </button>
                    </form>
                    <form action="{{ url('/login') }}" method="GET">
                        <button type="submit" class="border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition">
                            Login
                        </button>
                    </form>
                @endauth
            @endif
        </div>
    </nav>
</header>



<!-- Importa jQuery y SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para manejar la verificación del código con AJAX -->
<script>
    $(document).ready(function() {
        $('#codigoForm').on('submit', function(e) {
            e.preventDefault(); // Evita el envío normal del formulario
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

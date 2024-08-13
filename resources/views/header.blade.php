<div class="font-poppins">
    <header class="antialiased fixed top-0 left-0 right-0 z-50 bg-gray-900 bg-opacity-30 shadow-lg">
        <nav class="container mx-auto p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logoH.png') }}" alt="HealthCenter Logo" class="h-16 w-auto"> 
                </a>
                <span class="text-white text-2xl font-bold">Health Center</span> 
            </div>
            <div class="flex space-x-6 items-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white border-b-2 border-transparent hover:border-white transition">
                            Dashboard
                        </a>
                    @else
                        <form action="{{ url('/login') }}" method="GET">
                            <button type="submit" class="border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition">
                                Iniciar Sesión
                            </button>
                        </form>
                    @endauth
                @endif
            </div>
        </nav>
    </header>
</div>
    



@include("header")

<!-- Usando el diseño de invitado -->
<x-guest-layout>
        <!-- Contenedor principal con imagen de fondo -->
        <div>
            <h2 class="text-center text-2xl font-semibold text-white mb-4 uppercase">
                Iniciar sesión
            </h2>
        </div>

    <!-- Mostrar el estado de la sesión si existe -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulario de inicio de sesión -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Dirección de correo electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
                          
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Botones de acción -->
        <div class="flex items-center justify-end mt-4">

            <!-- Botón para iniciar sesión -->
            <x-primary-button class="ms-3">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

@include("footer")


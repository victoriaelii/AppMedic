<x-app-layout>
    <div class="min-h-screen flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="bg-white bg-opacity-80 shadow-lg rounded-lg p-8 max-w-lg w-full">
            <!-- Título del formulario -->
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Agregar Servicio</h2>
            
            <!-- Formulario para registrar un nuevo servicio -->
            <form method="POST" action="{{ route('servicios.store') }}">
                @csrf

                <!-- Nombre del Servicio -->
                <div class="mt-4">
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Precio -->
                <div class="mt-4">
                    <x-input-label for="precio" :value="__('Precio')" />
                    <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio')" required />
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <!-- Botón para registrar el servicio -->
                <div class="flex items-center justify-between mt-6">
                    <x-primary-button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                        {{ __('Registrar Servicio') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

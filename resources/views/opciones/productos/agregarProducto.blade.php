<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para agregar un nuevo producto -->
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf

            <!-- Nombre del Producto -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombre" :value="__('Nombre del Producto')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Precio -->
            <div class="mt-4 col-span-2">
                <x-input-label for="precio" :value="__('Precio')" />
                <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio')" required />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
            </div>

            <!-- Botón para agregar el producto -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Agregar Producto') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>

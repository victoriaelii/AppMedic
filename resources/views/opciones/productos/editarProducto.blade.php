<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para actualizar un producto -->
        <form method="POST" action="{{ route('productos.update', $producto->id) }}">
            @csrf
            @method('PATCH')

            <!-- Nombre del Producto -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombre" :value="__('Nombre del Producto')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$producto->nombre" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Precio -->
            <div class="mt-4 col-span-2">
                <x-input-label for="precio" :value="__('Precio')" />
                <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="$producto->precio" required autofocus />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
            </div>

            <!-- Botón para actualizar el producto -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Actualizar Producto') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>

<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('pacientes.store') }}">
            @csrf

            <!-- Campo oculto para la redirección -->
            <input type="hidden" name="redirect_to" value="{{ request()->input('redirect_to') }}">

            <!-- Campos del formulario para agregar un paciente -->

            <div class="mt-4">
                <x-input-label for="nombres" :value="__('Nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required />
                <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="apemat" :value="__('Apellido Materno')" />
                <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required />
                <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required />
                <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="correo" :value="__('Correo Electrónico')" />
                <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required />
                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
            </div>

            <!-- Botón para registrar el paciente -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Registrar Paciente') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>

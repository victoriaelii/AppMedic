<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para registrar una cita -->
        <form method="POST" action="{{ route('citas.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <!-- Fecha de la cita -->
                <div class="mt-4">
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="old('fecha')" required autofocus />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                </div>

                <!-- Hora de la cita -->
                <div class="mt-4">
                    <x-input-label for="hora" :value="__('Hora')" />
                    <x-text-input id="hora" class="block mt-1 w-full" type="time" name="hora" :value="old('hora')" required autofocus />
                    <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                </div>

                <!-- Selección de paciente -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="pacienteid" :value="__('Paciente')" />
                    <select id="pacienteid" name="pacienteid" class="block mt-1 w-full" required>
                        <!-- Iterar sobre los pacientes para crear las opciones del menú desplegable -->
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ old('pacienteid') == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />
                </div>
            </div>

            <!-- Botón para registrar la cita -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Registrar Cita') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>

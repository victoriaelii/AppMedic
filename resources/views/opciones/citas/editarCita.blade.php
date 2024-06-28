<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para actualizar una cita -->
        <form method="POST" action="{{ route('citas.update', $cita->id) }}">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4">
                <!-- Fecha de la cita -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="$cita->fecha" required autofocus min="{{ now()->toDateString() }}" max="{{ now()->addMonths(2)->toDateString() }}" />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                </div>

                <!-- Hora de la cita -->
                <div class="mt-4">
                    <x-input-label for="hora" :value="__('Hora')" />
                    <select id="hora" name="hora" class="block mt-1 w-full" required>
                        <option value="10:00" {{ $cita->hora == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                        <option value="11:00" {{ $cita->hora == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                        <option value="12:00" {{ $cita->hora == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                        <option value="13:00" {{ $cita->hora == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                        <option value="14:00" {{ $cita->hora == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                        <option value="15:00" {{ $cita->hora == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                        <option value="16:00" {{ $cita->hora == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                        <option value="17:00" {{ $cita->hora == '17:00' ? 'selected' : '' }}>5:00 PM</option>
                        <option value="18:00" {{ $cita->hora == '18:00' ? 'selected' : '' }}>6:00 PM</option>
                        <option value="19:00" {{ $cita->hora == '19:00' ? 'selected' : '' }}>7:00 PM</option>
                        <option value="20:00" {{ $cita->hora == '20:00' ? 'selected' : '' }}>8:00 PM</option>
                        <option value="21:00" {{ $cita->hora == '21:00' ? 'selected' : '' }}>9:00 PM</option>
                        <option value="22:00" {{ $cita->hora == '22:00' ? 'selected' : '' }}>10:00 PM</option>
                    </select>
                    <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                </div>

                <!-- Selección de paciente -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="pacienteid" :value="__('Paciente')" />
                    <select id="pacienteid" name="pacienteid" class="block mt-1 w-full" required>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ $cita->pacienteid == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />
                </div>
            </div>

            <!-- Botón para actualizar la cita -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Actualizar Cita') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>

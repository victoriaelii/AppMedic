<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para actualizar una cita -->
        <form method="POST" action="{{ route('citas.update', $cita->id) }}" id="updateForm">
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
                        @foreach (range(10, 22) as $hour)
                            @php
                                $time = sprintf('%02d:00:00', $hour); // Hora en formato HH:mm:ss
                                $displayTime = date('h:i A', strtotime($time)); // Hora en formato 12 horas
                            @endphp
                            <option value="{{ $time }}" {{ $cita->hora == $time ? 'selected' : '' }}>
                                {{ $displayTime }}
                            </option>
                        @endforeach
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

                <!-- Selección de médico -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="medicoid" :value="__('Médico')" />
                    <select id="medicoid" name="medicoid" class="block mt-1 w-full" required>
                        @foreach($medicos as $medico)
                            <option value="{{ $medico->id }}" {{ $cita->medicoid == $medico->id ? 'selected' : '' }}>
                                {{ $medico->nombres }} {{ $medico->apepat }} {{ $medico->apemat }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('medicoid')" class="mt-2" />
                </div>
            </div>

            <!-- Botón para actualizar la cita -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4" id="updateButton">
                    {{ __('Actualizar Cita') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>

    <!-- Script para SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('updateButton').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres actualizar esta cita?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizarla',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updateForm').submit();
                }
            });
        });
    </script>
</x-app-layout>

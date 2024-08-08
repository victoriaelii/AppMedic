<x-app-layout>
    <x-guest-layout>
        <!-- Formulario para registrar una cita -->
        <form method="POST" action="{{ route('citas.store') }}" id="registrar-cita-form">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <!-- Fecha de la cita -->
                <div class="mt-4">
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="old('fecha')" required autofocus min="{{ now()->toDateString() }}" max="{{ now()->addMonths(2)->toDateString() }}" />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                </div>

                <!-- Hora de la cita -->
                <div class="mt-4">
                    <x-input-label for="hora" :value="__('Hora')" />
                    <select id="hora" name="hora" class="block mt-1 w-full" required>
                        <option value="10:00" {{ old('hora') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                        <option value="11:00" {{ old('hora') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                        <option value="12:00" {{ old('hora') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                        <option value="13:00" {{ old('hora') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                        <option value="14:00" {{ old('hora') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                        <option value="15:00" {{ old('hora') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                        <option value="16:00" {{ old('hora') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                        <option value="17:00" {{ old('hora') == '17:00' ? 'selected' : '' }}>5:00 PM</option>
                        <option value="18:00" {{ old('hora') == '18:00' ? 'selected' : '' }}>6:00 PM</option>
                        <option value="19:00" {{ old('hora') == '19:00' ? 'selected' : '' }}>7:00 PM</option>
                        <option value="20:00" {{ old('hora') == '20:00' ? 'selected' : '' }}>8:00 PM</option>
                        <option value="21:00" {{ old('hora') == '21:00' ? 'selected' : '' }}>9:00 PM</option>
                        <option value="22:00" {{ old('hora') == '22:00' ? 'selected' : '' }}>10:00 PM</option>
                    </select>
                    <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                </div>

                <!-- Búsqueda de paciente -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="paciente_search" :value="__('Buscar Paciente')" />
                    <x-text-input id="paciente_search" class="block mt-1 w-full" type="text" name="paciente_search" placeholder="Buscar paciente por nombre, apellido o correo" autocomplete="off" />
                    <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />

                    <div id="paciente_suggestions" class="mt-2 bg-white border rounded shadow-lg"></div>
                </div>

                <!-- Campo oculto para almacenar el ID del paciente seleccionado -->
                <input type="hidden" name="pacienteid" id="pacienteid" value="{{ old('pacienteid') }}" required />

                <!-- Mostrar médico -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="medico" :value="__('Médico')" />
                    <x-text-input id="medico" class="block mt-1 w-full" type="text" name="medico" value="{{ $medicos->first()->nombres }} {{ $medicos->first()->apepat }} {{ $medicos->first()->apemat }}" readonly />
                    <input type="hidden" name="medicoid" id="medicoid" value="{{ $medicos->first()->id }}" />
                </div>
            </div>

            <!-- Botón para registrar la cita -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4" id="registrar-cita-btn">
                    {{ __('Registrar Cita') }}
                </x-primary-button>
            </div>
        </form>
        <a href="{{ route('agregarPaciente', ['redirect_to' => 'crearCita']) }}">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                {{ __('Registrar Paciente') }}
            </button>
        </a>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const pacienteSearch = document.getElementById('paciente_search');
                const pacienteSuggestions = document.getElementById('paciente_suggestions');
                const pacienteId = document.getElementById('pacienteid');
                const registrarCitaForm = document.getElementById('registrar-cita-form');
                const registrarCitaBtn = document.getElementById('registrar-cita-btn');

                // Búsqueda de paciente
                // Búsqueda de paciente
                pacienteSearch.addEventListener('input', function () {
                    const query = pacienteSearch.value;

                    if (query.length > 2) {
                        fetch(`/buscarPaciente?q=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                pacienteSuggestions.innerHTML = '';
                                data.forEach(paciente => {
                                    const div = document.createElement('div');
                                    div.textContent = `${paciente.nombres} ${paciente.apepat} ${paciente.apemat} - ${paciente.correo}`;
                                    div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                                    div.addEventListener('click', function () {
                                        pacienteId.value = paciente.id;
                                        pacienteSearch.value = `${paciente.nombres} ${paciente.apepat} ${paciente.apemat}`;
                                        pacienteSuggestions.innerHTML = '';
                                    });
                                    pacienteSuggestions.appendChild(div);
                                });
                            });
                    } else {
                        pacienteSuggestions.innerHTML = '';
                    }
                });


                registrarCitaBtn.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevenir el envío inmediato del formulario

                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'La cita ha sido registrada con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            registrarCitaForm.submit(); // Enviar el formulario después de mostrar el mensaje de éxito
                        }
                    });
                });

            });
        </script>
    </x-guest-layout>
</x-app-layout>

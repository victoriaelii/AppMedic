<x-app-layout>
    <div class="min-h-screen flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="bg-white bg-opacity-80 shadow-lg rounded-lg p-8 max-w-lg w-full">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Agregar Cita</h2>
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
                        <select id="hora" name="hora" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <!-- Opciones de horario -->
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
                <div class="flex items-center justify-between mt-6">
                    <x-primary-button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300" id="registrar-cita-btn">
                        {{ __('Registrar Cita') }}
                    </x-primary-button>

                    <a href="{{ route('agregarPaciente', ['redirect_to' => 'crearCita']) }}">
                        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            {{ __('Registrar Paciente') }}
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pacienteSearch = document.getElementById('paciente_search');
            const pacienteSuggestions = document.getElementById('paciente_suggestions');
            const pacienteId = document.getElementById('pacienteid');
            const registrarCitaForm = document.getElementById('registrar-cita-form');
            const registrarCitaBtn = document.getElementById('registrar-cita-btn');

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

            // SweetAlert para la confirmación de registro
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
</x-app-layout>

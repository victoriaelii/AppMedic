<x-app-layout>
    <div class="min-h-screen flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-10 max-w-2xl w-full">
            <!-- Título del formulario -->
            <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">Registrar Paciente</h2>
            
            <!-- Formulario para registrar un nuevo paciente -->
            <form method="POST" action="{{ route('pacientes.store') }}" onsubmit="return validateAge(event)">
                @csrf

                <!-- Campo oculto para la redirección -->
                <input type="hidden" name="redirect_to" value="{{ request()->input('redirect_to') }}">

                <!-- Campos del formulario para agregar un paciente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nombres" :value="__('Nombres')" />
                        <x-text-input id="nombres" class="block mt-1 w-full p-3" type="text" name="nombres" :value="old('nombres')" required autofocus />
                        <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                        <x-text-input id="apepat" class="block mt-1 w-full p-3" type="text" name="apepat" :value="old('apepat')" required />
                        <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="apemat" :value="__('Apellido Materno')" />
                        <x-text-input id="apemat" class="block mt-1 w-full p-3" type="text" name="apemat" :value="old('apemat')" required />
                        <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                        <x-text-input id="fechanac" class="block mt-1 w-full p-3" type="date" name="fechanac" :value="old('fechanac')" required />
                        <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="telefono" :value="__('Teléfono')" />
                        <x-text-input id="telefono" class="block mt-1 w-full p-3" type="text" name="telefono" :value="old('telefono')" required />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="correo" :value="__('Correo Electrónico')" />
                        <x-text-input id="correo" class="block mt-1 w-full p-3" type="email" name="correo" :value="old('correo')" required />
                        <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                    </div>
                </div>

                <!-- Botón para registrar el paciente -->
                <div class="flex items-center justify-end mt-8">
                    <x-primary-button class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-300 w-full md:w-auto">
                        {{ __('Registrar Paciente') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validateAge(event) {
            const fechaNac = document.getElementById('fechanac').value;
            const fechaActual = new Date();
            const fechaNacimiento = new Date(fechaNac);

            // Calcular la diferencia en meses entre la fecha de nacimiento y la fecha actual
            const diffYears = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
            const diffMonths = fechaActual.getMonth() - fechaNacimiento.getMonth() + (diffYears * 12);

            if (diffMonths < 1) {
                event.preventDefault(); // Prevenir el envío del formulario
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha de nacimiento inválida',
                    text: 'El paciente debe tener al menos un mes de edad.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            }
            return true;
        }
    </script>
</x-app-layout>

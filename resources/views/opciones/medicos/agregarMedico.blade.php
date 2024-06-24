<x-app-layout>
    <x-guest-layout>
        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">

        <!-- Formulario para registrar un nuevo médico -->
        <form id="register-form" method="POST" action="{{ route('medicos.store') }}">
            @csrf

            <!-- Nombres -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombres" :value="__('Nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Apellido Paterno -->
                <div class="mt-4">
                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                    <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                </div>

                <!-- Apellido Materno -->
                <div class="mt-4">
                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                    <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="mt-4">
                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mt-4">
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full" type="number" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Rol Medico -->
                <div class="mt-4 col-span-2">
                    <select id="rol" name="rol" class="block mt-1 w-full" required>
                        <option value="medico" {{ old('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                        <option value="secretaria" {{ old('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                        <option value="colaborador" {{ old('rol') == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                    </select>
                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="mt-4 col-span-2">
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Botón para registrar el médico -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Registrar Usuario') }}
                </x-primary-button>
            </div>
        </form>

        <!-- SweetAlert2 JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('register-form').addEventListener('submit', function(event) {
                var birthDate = new Date(document.getElementById('fechanac').value);
                var today = new Date();
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 18) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Debes tener al menos 18 años para registrarte.',
                    });
                }
            });
        </script>

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('medicos') }}";
                    }
                });
            </script>
        @endif
    </x-guest-layout>
</x-app-layout>

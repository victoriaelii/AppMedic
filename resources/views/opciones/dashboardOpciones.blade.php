<x-app-layout>
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Pacientes</h1>
                            <a href="{{ route('agregarPaciente', ['redirect_to' => 'dashboardOpciones']) }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Registrar Paciente') }}
                                </button>
                            </a>
                        </div>
                        <form method="GET" action="{{ route('dashboardOpciones') }}" class="flex mb-4 space-x-4">
                            <input type="text" name="nombre" placeholder="Nombre del Paciente" class="border border-gray-300 p-2 rounded-md" value="{{ request('nombre') }}">
                            <input type="date" name="fechanac" class="border border-gray-300 p-2 rounded-md" value="{{ request('fechanac') }}">
                            <input type="email" name="correo" placeholder="Correo del Paciente" class="border border-gray-300 p-2 rounded-md" value="{{ request('correo') }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Buscar</button>
                            <a href="{{ route('dashboardOpciones') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Limpiar</a>
                        </form>
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Nombres</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Correo</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Teléfono</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Código</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                @foreach($pacientes as $paciente)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-center">{{ $paciente->nombres }}</td>
                                        <td class="px-6 py-4 text-center">{{ $paciente->apepat }}</td>
                                        <td class="px-6 py-4 text-center">{{ $paciente->apemat }}</td>
                                        <td class="px-6 py-4 text-center">{{ $paciente->fechanac }}</td>
                                        <td class="px-6 py-4 text-center">{{ $paciente->correo }}</td>
                                        <td class="px-6 py-4 text-center">{{ $paciente->telefono }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($paciente->codigo)
                                                {{ $paciente->codigo }}
                                            @else
                                                <form action="{{ route('pacientes.generarCodigo', $paciente->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 transition">Generar código</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center flex items-center justify-center space-x-2">
                                            <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-600 hover:text-blue-900 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50" fill="currentColor">
                                                    <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875 44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375 6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z"></path>
                                                </svg>
                                            </a>
                                            @if(Auth::user()->rol != 'secretaria')
                                                <form id="delete-form-{{ $paciente->id }}" action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDeletion({{ $paciente->id }})" class="text-red-600 hover:text-red-900 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 26 26">
                                                            <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($paciente->citas->contains(fn($cita) => $cita->consulta && $cita->consulta->estado == 'finalizada'))
                                                <a href="{{ route('historialMedico.show', $paciente->id) }}" class="text-green-600 hover:text-green-900 transition">Historial</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($pacientes->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay pacientes registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeletion(pacienteId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + pacienteId).submit();
                }
            })
        }
    </script>
</x-app-layout>

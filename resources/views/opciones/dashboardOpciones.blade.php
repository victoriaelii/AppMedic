<x-app-layout>
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Pacientes</h1>
                            <div class="flex items-center space-x-2 bg-blue-100 text-blue-600 px-4 py-2 rounded-full shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <span class="text-lg font-medium">Total de pacientes activos: {{ $totalPacientesActivos }}</span>
                            </div>
                            <a href="{{ route('agregarPaciente', ['redirect_to' => 'dashboardOpciones']) }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                                    {{ __('Registrar Paciente') }}
                                </button>
                            </a>
                        </div>
                        
                        
                        <form method="GET" action="{{ route('dashboardOpciones') }}" class="flex mb-6 space-x-4">
                            <input type="text" name="nombre" placeholder="Nombre del Paciente" class="border border-gray-300 p-3 rounded-md" value="{{ request('nombre') }}">
                            <input type="date" name="fechanac" class="border border-gray-300 p-3 rounded-md" value="{{ request('fechanac') }}">
                            <input type="email" name="correo" placeholder="Correo del Paciente" class="border border-gray-300 p-3 rounded-md" value="{{ request('correo') }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300">Buscar</button>
                            <a href="{{ route('dashboardOpciones') }}" class="bg-gray-500 text-white px-4 py-3 rounded-md hover:bg-gray-600 transition duration-300">Limpiar</a>
                        </form>

                        <!-- Tabla de pacientes -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.7);">
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
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.7);">
                                @foreach($pacientes as $paciente)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.7);">
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
                                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 transition duration-300">Generar código</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-green-600 hover:text-green-900 transition duration-300">
                                                    <!-- Ícono de edición -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                @if($paciente->citas->contains(fn($cita) => $cita->consulta && $cita->consulta->estado == 'finalizada'))
                                                    <a href="{{ route('historialMedico.show', $paciente->id) }}" class="text-blue-600 hover:text-blue-900 transition duration-300">
                                                        <!-- Ícono para ver historial -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if(Auth::user()->rol != 'secretaria')
                                                    <form id="delete-form-{{ $paciente->id }}" action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDeletion({{ $paciente->id }})" class="text-red-600 hover:text-red-900 transition duration-300">
                                                            <!-- Ícono de eliminación -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
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

<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor interior -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados, con fondo blanco semitransparente -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <!-- Contenido interior -->
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">


                        <!-- Encabezado de la sección -->
                        <div class="flex my-4 items-center justify-between">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Usuarios</h1>
                            <!-- Botón para agregar nuevo médico -->
                            <a href="{{ route('medicos.agregar') }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Agregar Usuario') }}
                                </button>
                            </a>
                        </div>
                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('medicos') }}" class="mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                <div>
                                    <input type="text" name="nombre" placeholder="Buscar por nombre" value="{{ request('nombre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <input type="text" name="correo" placeholder="Buscar por correo" value="{{ request('correo') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <select name="rol" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Filtrar por rol</option>
                                        <option value="medico" {{ request('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                                        <option value="secretaria" {{ request('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                        <option value="enfermera" {{ request('rol') == 'enfermera' ? 'selected' : '' }}>Enfermera</option>
                                    </select>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Buscar</button>
                                    <a href="{{ route('medicos') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Limpiar</a>
                                </div>
                            </div>
                        </form>

                        <!-- Mostrar mensaje de error si existe -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Error:</strong>
                                <span class="block sm:inline">{{ $errors->first('error') }}</span>
                            </div>
                        @endif
                        <!-- Tabla de médicos -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <!-- Cabecera de la tabla -->
                            <thead class="bg-gray-50 border-b text-center" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Nombres</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Correo</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Teléfono</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Rol</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla -->
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- Iterar sobre los médicos y mostrar cada uno en una fila -->
                                @foreach($medicos as $medico)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-center">{{ $medico->nombres }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->apepat }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->apemat }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->fechanac }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->email }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->telefono }}</td>
                                        <td class="px-6 py-4 text-center">{{ $medico->rol }}</td>
                                        <td class="px-6 py-4 text-center flex items-center space-x-2">
                                            <!-- Enlace para editar el médico -->
                                            <a href="{{ route('medicos.editar', $medico->id) }}" class="text-yellow-600 hover:yellow-blue-900 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <!-- Formulario para eliminar el médico -->
                                            <form action="{{ route('medicos.eliminar', $medico->id) }}" method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-900 transition delete-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay médicos registrados -->
                        @if($medicos->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay usuarios registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Incluir SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script para manejar la confirmación de eliminación -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

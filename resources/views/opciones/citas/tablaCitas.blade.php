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
                        <!-- Encabezado de la tabla -->
                        <div class="flex my-4 items-center justify-between">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Citas</h1>
                            <!-- Botón para agregar nueva cita -->
                            <a href="{{ route('crearCita') }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Agregar Cita') }}
                                </button>
                            </a>
                        </div>
                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('tablaCitas') }}" class="mb-4">
                            <div class="flex space-x-4">
                                <input type="text" name="nombre" placeholder="Nombre del Paciente" class="border border-gray-300 p-2 rounded-md" value="{{ request('nombre') }}">
                                <input type="date" name="fecha" class="border border-gray-300 p-2 rounded-md" value="{{ request('fecha') }}">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Buscar') }}
                                </button>
                            </div>
                        </form>
                        <!-- Tabla de citas -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <!-- Cabecera de la tabla -->
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6); border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Hora</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Paciente</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Médico</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla -->
                            <tbody class="bg-white" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- mostrar cada una en una fila -->
                                @foreach($citas as $cita)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-left">{{ $cita->fecha }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->hora }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->medico->nombres }}</td>
                                        <td class="px-6 py-4 text-left flex items-center space-x-2">
                                            <!-- Enlace para editar la cita -->
                                            <a href="{{ route('citas.editar', $cita->id) }}" class="text-blue-600 hover:text-blue-900 transition">Editar</a>
                                            <!-- Formulario para eliminar la cita -->
                                            <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-900 transition delete-button">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay citas registradas -->
                        @if($citas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay citas registradas.</p>
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

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
                            <a href="{{ route('citas.agregar') }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Agregar Cita') }}
                                </button>
                            </a>
                        </div>
                        <!-- Tabla de citas -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <!-- Cabecera de la tabla -->
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Hora</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Paciente</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Activo</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla -->
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- Iterar sobre las citas y mostrar cada una en una fila -->
                                @foreach($citas as $cita)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-left">{{ $cita->fecha }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->hora }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->activo }}</td>
                                        <td class="px-6 py-4 text-left flex items-center space-x-2">
                                            <!-- Enlace para editar la cita -->
                                            <a href="{{ route('citas.editar', $cita->id) }}" class="text-blue-600 hover:text-blue-900 transition">Editar</a>
                                            <!-- Formulario para eliminar la cita -->
                                            <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Eliminar</button>
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

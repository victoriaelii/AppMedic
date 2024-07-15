<x-app-layout>
    <!-- Página con imagen de fondo y estilos -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor principal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <!-- Encabezado de la sección -->
                        <div class="flex my-4 items-center justify-between">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Por consultar</h1>
                        </div>
                        <!-- Tabla de citas -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6); border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Hora</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Paciente</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Total a Pagar</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- Iterar sobre las citas y mostrar cada una en una fila -->
                                @foreach($citas as $cita)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-left">{{ $cita->fecha }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->hora }}</td>
                                        <td class="px-6 py-4 text-left">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                        <td class="px-6 py-4 text-left">
                                            @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                                ${{ number_format($cita->consulta->totalPagar, 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                                <span class="bg-green-600 text-white px-4 py-2 rounded-md">Listo</span>
                                            @else
                                                @if($cita->consulta)
                                                    <!-- Si la consulta ya existe, mostrar botones para editar y terminar -->
                                                    <a href="{{ route('consultas.edit', $cita->consulta->id) }}">
                                                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                                            {{ __('Editar consulta') }}
                                                        </button>
                                                    </a>
                                                    <form action="{{ route('consultas.terminar', $cita->consulta->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                                                            {{ __('Terminar consulta') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Si no existe consulta, mostrar botón para crear una -->
                                                    <a href="{{ route('consultas.form', $cita->id) }}">
                                                        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                                                            {{ __('Ir a consulta') }}
                                                        </button>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $citas->links() }}
                        </div>
                        <!-- Mensaje si no hay citas -->
                        @if($citas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay citas registradas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Historial Médico de {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</h1>
                            <!-- Botón para descargar el historial médico en PDF -->
                            <a href="{{ route('historialMedico.pdf', $paciente->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                {{ __('Descargar PDF') }}
                            </a>
                        </div>
                        <!-- Tabla de historial médico -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <!-- Cabecera de la tabla -->
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Diagnóstico</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Receta</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Servicios</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Productos</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Total a Pagar</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla -->
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- Iterar sobre las consultas del paciente y mostrar cada una en una fila -->
                                @foreach($paciente->citas as $cita)
                                    @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                        <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                            <td class="px-6 py-4 text-left">{{ $cita->fecha }}</td>
                                            <td class="px-6 py-4 text-left">{{ $cita->consulta->diagnostico }}</td>
                                            <td class="px-6 py-4 text-left">{{ $cita->consulta->recete }}</td>
                                            <td class="px-6 py-4 text-left">
                                                @foreach($cita->consulta->servicios as $servicio)
                                                    <p>{{ $servicio->nombre }}</p>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-left">
                                                @foreach($cita->consulta->productos as $producto)
                                                    <p>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }})</p>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-left">${{ number_format($cita->consulta->totalPagar, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay historial médico -->
                        @if($paciente->citas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay historial médico disponible.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor interior -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados, con fondo blanco semitransparente -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <!-- Contenido interior -->
                <div class="p-6 text-gray-900">
                    <!-- Encabezado de la sección -->
                    <div class="flex my-4 items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-800 uppercase">Historial Médico de {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</h1>
                        <!-- Botón para descargar el historial médico en PDF -->
                        <a href="{{ route('historialMedico.pdf', $paciente->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            {{ __('Descargar PDF') }}
                        </a>
                    </div>
                    <!-- Historial médico en lista -->
                    <div class="space-y-4">
                        @foreach($paciente->citas as $cita)
                            @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                <div class="p-4 bg-white shadow rounded-md">
                                    <h2 class="text-xl font-bold">Fecha: {{ $cita->fecha }}</h2>
                                    <p><strong>Diagnóstico:</strong> {{ $cita->consulta->diagnostico }}</p>
                                    <p><strong>Receta:</strong> {{ $cita->consulta->recete }}</p>
                                    <p><strong>Signos Vitales:</strong> {{ $cita->consulta->signos_vitales }}</p>
                                    <p><strong>Motivo de Consulta:</strong> {{ $cita->consulta->motivo_consulta }}</p>
                                    <p><strong>Notas del Padecimiento:</strong> {{ $cita->consulta->notas_padecimiento }}</p>
                                    <p><strong>Examen Físico:</strong> {{ $cita->consulta->examen_fisico }}</p>
                                    <p><strong>Pronóstico:</strong> {{ $cita->consulta->pronostico }}</p>
                                    <p><strong>Plan de Tratamiento:</strong> {{ $cita->consulta->plan }}</p>
                                    <p><strong>Alergias:</strong> {{ $cita->consulta->alergias }}</p>
                                    <p><strong>Servicios:</strong></p>
                                    <ul class="list-disc pl-5">
                                        @foreach($cita->consulta->servicios as $servicio)
                                            <li>{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}</li>
                                        @endforeach
                                    </ul>
                                    <p><strong>Productos:</strong></p>
                                    <ul class="list-disc pl-5">
                                        @foreach($cita->consulta->productos as $producto)
                                            <li>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }}) - ${{ number_format($producto->precio, 2) }} c/u, Total: ${{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</li>
                                        @endforeach
                                    </ul>
                                    <p><strong>Total a Pagar:</strong> ${{ number_format($cita->consulta->totalPagar, 2) }}</p>
                                </div>
                            @endif
                        @endforeach
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

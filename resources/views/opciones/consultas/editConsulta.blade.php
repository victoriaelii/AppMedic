<x-app-layout>
    <!-- Página con una imagen de fondo y estilos -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor principal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <!-- Formulario para actualizar una consulta -->
                    <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Título del formulario -->
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Editar Consulta para {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}</h2>
                        </div>

                        <!-- Campo para el diagnóstico -->
                        <div class="mb-4">
                            <label for="diagnostico" class="block text-gray-700">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->diagnostico }}</textarea>
                        </div>

                        <!-- Campo para la receta -->
                        <div class="mb-4">
                            <label for="recete" class="block text-gray-700">Receta:</label>
                            <textarea name="recete" id="recete" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->recete }}</textarea>
                        </div>

                        <!--información médica -->
                        <div class="mb-4">
                            <label for="signos_vitales" class="block text-gray-700">Signos Vitales:</label>
                            <textarea name="signos_vitales" id="signos_vitales" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->signos_vitales }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="motivo_consulta" class="block text-gray-700">Motivo de Consulta:</label>
                            <textarea name="motivo_consulta" id="motivo_consulta" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->motivo_consulta }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="notas_padecimiento" class="block text-gray-700">Notas del Padecimiento:</label>
                            <textarea name="notas_padecimiento" id="notas_padecimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->notas_padecimiento }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="examen_fisico" class="block text-gray-700">Examen Físico:</label>
                            <textarea name="examen_fisico" id="examen_fisico" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->examen_fisico }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="pronostico" class="block text-gray-700">Pronóstico:</label>
                            <textarea name="pronostico" id="pronostico" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->pronostico }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="plan" class="block text-gray-700">Plan de Tratamiento:</label>
                            <textarea name="plan" id="plan" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->plan }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="alergias" class="block text-gray-700">Alergias:</label>
                            <textarea name="alergias" id="alergias" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ $consulta->alergias }}</textarea>
                        </div>
                        
                        <!-- Selección de servicios -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Servicios:</label>
                            @foreach ($servicios as $servicio)
                                <div class="flex items-center">
                                    <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" class="mr-2" @if($consulta->servicios->contains($servicio->id)) checked @endif>
                                    <label>{{ $servicio->nombre }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Selección de productos -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Productos:</label>
                            @foreach ($productos as $producto)
                                <div class="flex items-center">
                                    <input type="checkbox" name="productos[]" value="{{ $producto->id }}" class="mr-2" @if($consulta->productos->contains($producto->id)) checked @endif>
                                    <label>{{ $producto->nombre }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón para actualizar la consulta -->
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Actualizar Consulta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

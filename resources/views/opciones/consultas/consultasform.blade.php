<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor interior centrado -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <!-- Formulario de registro de consulta -->
                    <form id="consultasForm" method="POST">
                        @csrf
                        <!-- Campo oculto con el ID de la cita -->
                        <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                        <div>
                            <h2 class="text-xl font-semibold mb-4">Registrar Consulta para {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</h2>
                        </div>

                        <!-- CAMPOS DE LA consulta -->
                        <div class="mb-4">
                            <label for="diagnostico" class="block text-gray-700">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" required class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="recete" class="block text-gray-700">Receta:</label>
                            <textarea name="recete" id="recete" required class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="signos_vitales" class="block text-gray-700">Signos Vitales:</label>
                            <textarea name="signos_vitales" id="signos_vitales" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="motivo_consulta" class="block text-gray-700">Motivo de Consulta:</label>
                            <textarea name="motivo_consulta" id="motivo_consulta" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="notas_padecimiento" class="block text-gray-700">Notas del Padecimiento:</label>
                            <textarea name="notas_padecimiento" id="notas_padecimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="examen_fisico" class="block text-gray-700">Examen Físico:</label>
                            <textarea name="examen_fisico" id="examen_fisico" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="pronostico" class="block text-gray-700">Pronóstico:</label>
                            <textarea name="pronostico" id="pronostico" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="plan" class="block text-gray-700">Plan de Tratamiento:</label>
                            <textarea name="plan" id="plan" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="alergias" class="block text-gray-700">Alergias:</label>
                            <textarea name="alergias" id="alergias" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                        
                        <!-- Servicios -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Servicios:</label>
                            @foreach ($servicios as $servicio)
                                <div class="flex items-center">
                                    <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" class="mr-2">
                                    <label>{{ $servicio->nombre }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Productos -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Productos:</label>
                            @foreach ($productos as $producto)
                                <div class="flex items-center">
                                    <input type="checkbox" name="productos[]" value="{{ $producto->id }}" class="mr-2">
                                    <label>{{ $producto->nombre }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón para guardar la consulta -->
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Guardar Consulta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- biblioteca SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('consultasForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let form = event.target;
            let formData = new FormData(form);

            // Enviar el formulario usando fetch
            fetch('{{ route('consultas.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al guardar la consulta');
                }
                return response.json();
            })
            .then(data => {
                if (data.status) {
                    let detalles = '';
                    // Crear la lista de detalles de costos
                    data.detalleCostos.forEach(detalle => {
                        detalles += `${detalle.nombre}: $${parseFloat(detalle.precio).toFixed(2)}<br>`;
                    });
                    detalles += `Costo base de la consulta: $100.00<br>`;
                    detalles += `<strong>Total a pagar: $${data.totalPagar.toFixed(2)}</strong>`;

                    // Mostrar SweetAlert con los detalles
                    Swal.fire({
                        title: 'Consulta guardada',
                        html: detalles,
                        icon: 'success'
                    }).then(() => {
                        window.location.href = "{{ route('consultas.porConsultar') }}";
                    });
                } else {
                    throw new Error('Error al guardar la consulta');
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error'
                });
            });
        });
    </script>
</x-app-layout>

<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12 flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Estilo personalizado para ocultar las flechas en los inputs numéricos -->
        <style>
            /* Estilo para ocultar las flechas de los inputs numéricos */
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield; /* Firefox */
            }
        </style>

        <!-- Contenedor interior centrado con transparencia -->
        <div class="max-w-4xl w-full mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados con transparencia -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-8" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
                <div class="text-gray-900">
                    <!-- Formulario de registro de consulta -->
                    <form id="consultasForm" method="POST">
                        @csrf
                        <!-- Campo oculto con el ID de la cita -->
                        <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                        <div class="mb-6 text-center">
                            <h2 class="text-2xl font-semibold text-gray-800">Registrar Consulta</h2>
                            <p class="text-lg text-gray-600">Paciente: {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</p>
                        </div>

                        <!-- CAMPOS DE LA consulta -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="diagnostico" class="block text-gray-700 font-medium">Diagnóstico:</label>
                                <textarea name="diagnostico" id="diagnostico" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="recete" class="block text-gray-700 font-medium">Receta:</label>
                                <textarea name="recete" id="recete" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <!-- SIGNOS VITALES -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Signos Vitales:</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="talla" class="block text-gray-700 font-medium">Talla (m):</label>
                                    <input type="number" name="talla" id="talla" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="temperatura" class="block text-gray-700 font-medium">Temperatura (°C):</label>
                                    <input type="number" step="0.1" name="temperatura" id="temperatura" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="saturacion" class="block text-gray-700 font-medium">Saturación de oxígeno (%):</label>
                                    <input type="number" name="saturacion" id="saturacion" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="frecuencia_cardiaca" class="block text-gray-700 font-medium">Frecuencia cardíaca (bpm):</label>
                                    <input type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="peso" class="block text-gray-700 font-medium">Peso (kg):</label>
                                    <input type="number" name="peso" id="peso" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="tension_arterial" class="block text-gray-700 font-medium">Tensión arterial (mm/Hg):</label>
                                    <input type="text" name="tension_arterial" id="tension_arterial" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="motivo_consulta" class="block text-gray-700 font-medium">Motivo de Consulta:</label>
                                <textarea name="motivo_consulta" id="motivo_consulta" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="notas_padecimiento" class="block text-gray-700 font-medium">Notas del Padecimiento:</label>
                                <textarea name="notas_padecimiento" id="notas_padecimiento" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="examen_fisico" class="block text-gray-700 font-medium">Examen Físico:</label>
                                <textarea name="examen_fisico" id="examen_fisico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="pronostico" class="block text-gray-700 font-medium">Pronóstico:</label>
                                <textarea name="pronostico" id="pronostico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="plan" class="block text-gray-700 font-medium">Plan de Tratamiento:</label>
                                <textarea name="plan" id="plan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="alergias" class="block text-gray-700 font-medium">Alergias:</label>
                                <textarea name="alergias" id="alergias" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <!-- Servicios y Productos -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-medium">Servicios:</label>
                                @foreach ($servicios as $servicio)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" class="mr-2" data-precio="{{ $servicio->precio }}" onchange="actualizarTotal()">
                                        <label>{{ $servicio->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-medium">Productos:</label>
                                @foreach ($productos as $producto)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}" class="mr-2" onclick="toggleCantidad(this)" data-precio="{{ $producto->precio }}" onchange="actualizarTotal()">
                                        <label>{{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}</label>
                                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" min="1" max="{{ $producto->cantidad }}" class="ml-4 p-2 border rounded-md w-20" disabled data-producto-id="{{ $producto->id }}" onchange="actualizarTotal()">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Enfermera -->
                        <div class="mt-6">
                            <label for="enfermera_id" class="block text-gray-700 font-medium">Enfermera (opcional):</label>
                            <select name="enfermera_id" id="enfermera_id" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar enfermera</option>
                                @foreach ($enfermeras as $enfermera)
                                    <option value="{{ $enfermera->id }}">{{ $enfermera->nombres }} {{ $enfermera->apepat }} ({{ $enfermera->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total a pagar -->
                        <div class="mt-6">
                            <label class="block text-gray-700 font-medium">Total a Pagar:</label>
                            <input type="text" id="totalPagar" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" readonly>
                        </div>

                        <!-- Botón para guardar la consulta -->
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition text-lg font-medium">Guardar Consulta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- biblioteca SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleCantidad(checkbox) {
            const cantidadInput = checkbox.parentElement.querySelector('input[type="number"]');
            if (checkbox.checked) {
                cantidadInput.disabled = false;
                cantidadInput.value = ''; // Deja el campo vacío cuando se selecciona el check
            } else {
                cantidadInput.disabled = true;
                cantidadInput.value = ''; // Deja el campo vacío cuando se quita el check
            }
            actualizarTotal(); // Actualizar el total cuando se selecciona/deselecciona un producto
        }

        function actualizarTotal() {
            let total = 100; // Precio base de la consulta
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const precio = parseFloat(checkbox.getAttribute('data-precio'));
                if (checkbox.name.startsWith('productos')) {
                    const cantidadInput = checkbox.parentElement.querySelector('input[type="number"]');
                    const cantidad = parseFloat(cantidadInput.value) || 0;
                    total += precio * cantidad;
                } else {
                    total += precio;
                }
            });
            document.getElementById('totalPagar').value = `$${total.toFixed(2)}`;
        }

        document.getElementById('consultasForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Obtener los valores de los campos de signos vitales
            const talla = document.getElementById('talla').value;
            const temperatura = document.getElementById('temperatura').value;
            const saturacion = document.getElementById('saturacion').value;
            const frecuencia_cardiaca = document.getElementById('frecuencia_cardiaca').value;
            const peso = document.getElementById('peso').value;
            const tension_arterial = document.getElementById('tension_arterial').value;

            // Concatenar los valores en una cadena de texto
            const signosVitales = `Talla: ${talla} m, Temperatura: ${temperatura} °C, Saturación de oxígeno: ${saturacion} %, Frecuencia cardíaca: ${frecuencia_cardiaca} bpm, Peso: ${peso} kg, Tensión arterial: ${tension_arterial} mm/Hg`;

            // Crear un input oculto para enviar los signos vitales concatenados
            const signosVitalesInput = document.createElement('input');
            signosVitalesInput.type = 'hidden';
            signosVitalesInput.name = 'signos_vitales';
            signosVitalesInput.value = signosVitales;
            event.target.appendChild(signosVitalesInput);

            let form = event.target;
            let formData = new FormData(form);

            // cantidades de productos no seleccionados se establezcan en 0
            document.querySelectorAll('input[type="number"][data-producto-id]').forEach(input => {
                let checkbox = document.querySelector(`input[type="checkbox"][value="${input.dataset.productoId}"]`);
                if (!checkbox.checked) {
                    formData.append(input.name, 0);
                }
            });

            // Enviar el formulario 
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
                    return response.json().then(data => {
                        throw new Error(data.error || 'Error al guardar la consulta');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.status) {
                    let detalles = '';
                    // Crear la lista de detalles de costos
                    data.detalleCostos.forEach(detalle => {
                        if (detalle.tipo === 'servicio') {
                            detalles += `${detalle.nombre}: $${parseFloat(detalle.precio).toFixed(2)}<br>`;
                        } else {
                            detalles += `${detalle.nombre} (Cantidad: ${detalle.cantidad}): $${parseFloat(detalle.precio).toFixed(2)}<br>`;
                        }
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

        // Inicializar el total al cargar la página
        actualizarTotal();

    </script>
</x-app-layout>

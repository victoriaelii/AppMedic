<x-app-layout>
    <div class="min-h-screen py-12 flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <style>
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type="number"] {
                -moz-appearance: textfield;
            }
        </style>

        <div class="max-w-4xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-8" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
                <div class="text-gray-900">
                    <form id="consultasForm" method="POST" action="{{ route('consultas.store') }}">
                        @csrf
                        <input type="hidden" name="cita_id" value="{{ $cita->id }}">

                        <div class="mb-6 text-center">
                            <h2 class="text-2xl font-semibold text-gray-800">Registrar Consulta</h2>
                            <p class="text-lg text-gray-600">Paciente: {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</p>
                        </div>

                        <!-- Motivo de la Consulta -->
                        <div class="mb-6">
                            <label for="motivo_consulta" class="block text-gray-700 font-medium">Motivo de Consulta:</label>
                            <textarea name="motivo_consulta" id="motivo_consulta" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Signos Vitales -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Signos Vitales:</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="talla" class="block text-gray-700 font-medium">Talla (m):</label>
                                    <input type="number" name="talla" id="talla" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                <div>
                                    <label for="temperatura" class="block text-gray-700 font-medium">Temperatura (°C):</label>
                                    <input type="number" step="0.1" name="temperatura" id="temperatura" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                <div>
                                    <label for="saturacion" class="block text-gray-700 font-medium">Saturación de oxígeno (%):</label>
                                    <input type="number" name="saturacion" id="saturacion" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                <div>
                                    <label for="frecuencia_cardiaca" class="block text-gray-700 font-medium">Frecuencia cardíaca (bpm):</label>
                                    <input type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                <div>
                                    <label for="peso" class="block text-gray-700 font-medium">Peso (kg):</label>
                                    <input type="number" name="peso" id="peso" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                <div>
                                    <label for="tension_arterial" class="block text-gray-700 font-medium">Tensión arterial (mm/Hg):</label>
                                    <input type="text" name="tension_arterial" id="tension_arterial" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Notas del Padecimiento -->
                        <div class="mb-6">
                            <label for="notas_padecimiento" class="block text-gray-700 font-medium">Notas del Padecimiento:</label>
                            <textarea name="notas_padecimiento" id="notas_padecimiento" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Diagnóstico -->
                        <div class="mb-6">
                            <label for="diagnostico" class="block text-gray-700 font-medium">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Alergias -->
                        <div class="mb-6">
                            <label for="alergias" class="block text-gray-700 font-medium">Alergias:</label>
                            <textarea name="alergias" id="alergias" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Examen Físico -->
                        <div class="mb-6">
                            <label for="examen_fisico" class="block text-gray-700 font-medium">Examen Físico:</label>
                            <textarea name="examen_fisico" id="examen_fisico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Pronóstico -->
                        <div class="mb-6">
                            <label for="pronostico" class="block text-gray-700 font-medium">Pronóstico:</label>
                            <textarea name="pronostico" id="pronostico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Receta -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium text-lg">
                                <i class="fas fa-prescription-bottle-alt"></i> Receta
                            </label>
                            <p class="text-gray-600">Ingresa la siguiente información para recetar un medicamento</p>
                            
                            <div id="recetaFields">
                                <div class="grid grid-cols-5 gap-4 receta-item">
                                    <input type="text" name="medicacion[]" placeholder="Medicación" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                                    <input type="number" name="cantidad[]" placeholder="Cantidad" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                                    <input type="text" name="frecuencia[]" placeholder="Frecuencia" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                                    <input type="text" name="duracion[]" placeholder="Duración" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                                    <button type="button" class="delete-button text-red-600 mt-2" onclick="removeRecetaItem(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 26 26">
                                            <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
                                        </svg>
                                    </button>
                                    
                                </div>
                            </div>
                            <button type="button" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md" id="addRecetaButton">
                                Agregar medicamento
                            </button>

                            <!-- Campo para agregar notas generales de la receta -->
                            <div class="mt-4">
                                <label for="notas_receta" class="block text-gray-700 font-medium">Agregar notas:</label>
                                <textarea name="notas_receta" id="notas_receta" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>


                        </div>

                        <div class="mb-6">
                            <label for="plan" class="block text-gray-700 font-medium">Plan de Tratamiento:</label>
                            <textarea name="plan" id="plan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Servicios y Productos -->
                        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" min="1" max="{{ $producto->cantidad }}" class="ml-4 p-2 border rounded-md w-20" disabled data-producto-id="{{ $producto->id }}" oninput="this.value=this.value.replace(/[^0-9]/g,''); actualizarTotal();">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Enfermera -->
                        <div class="mb-6">
                            <label for="enfermera_id" class="block text-gray-700 font-medium">Enfermera (opcional):</label>
                            <select name="enfermera_id" id="enfermera_id" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar enfermera</option>
                                @foreach ($enfermeras as $enfermera)
                                    <option value="{{ $enfermera->id }}">{{ $enfermera->nombres }} {{ $enfermera->apepat }} ({{ $enfermera->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total a pagar -->
                        <div class="mb-6">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('addRecetaButton').addEventListener('click', function() {
            const recetaItem = document.createElement('div');
            recetaItem.classList.add('grid', 'grid-cols-5', 'gap-4', 'receta-item', 'mt-4');

            recetaItem.innerHTML = `
                <input type="text" name="medicacion[]" placeholder="Medicación" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <input type="number" name="cantidad[]" placeholder="Cantidad" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <input type="text" name="frecuencia[]" placeholder="Frecuencia" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <input type="text" name="duracion[]" placeholder="Duración" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <button type="button" class="delete-button text-red-600 mt-2" onclick="removeRecetaItem(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 26 26">
                        <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
                    </svg>
                </button>
            `;
            
            document.getElementById('recetaFields').appendChild(recetaItem);
        });

        function removeRecetaItem(button) {
            button.parentElement.remove();
        }

        document.getElementById('consultasForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Recolección de medicaciones
            let medicaciones = [];
            document.querySelectorAll('.receta-item').forEach(item => {
                const medicacion = item.querySelector('input[name="medicacion[]"]').value;
                const cantidad = item.querySelector('input[name="cantidad[]"]').value;
                const frecuencia = item.querySelector('input[name="frecuencia[]"]').value;
                const duracion = item.querySelector('input[name="duracion[]"]').value;

                medicaciones.push(`Medicación: ${medicacion}, Cantidad: ${cantidad}, Frecuencia: ${frecuencia}, Duración: ${duracion}`);
            });

            const notasReceta = document.getElementById('notas_receta').value;

            const recetaCompleta = medicaciones.join(' | ') + (notasReceta ? ` | Notas: ${notasReceta}` : '');

            const recetaInput = document.createElement('input');
            recetaInput.type = 'hidden';
            recetaInput.name = 'recete';
            recetaInput.value = recetaCompleta;
            event.target.appendChild(recetaInput);

            // Concatenación de signos vitales sin caracteres especiales
            const talla = document.getElementById('talla').value;
            const temperatura = document.getElementById('temperatura').value;
            const saturacion = document.getElementById('saturacion').value;
            const frecuencia_cardiaca = document.getElementById('frecuencia_cardiaca').value;
            const peso = document.getElementById('peso').value;
            const tension_arterial = document.getElementById('tension_arterial').value;

            const signosVitales = `Talla: ${talla}, Temperatura: ${temperatura}, Saturacion: ${saturacion}, Frecuencia cardiaca: ${frecuencia_cardiaca}, Peso: ${peso}, Tension arterial: ${tension_arterial}`;

            const signosVitalesInput = document.createElement('input');
            signosVitalesInput.type = 'hidden';
            signosVitalesInput.name = 'signos_vitales';
            signosVitalesInput.value = signosVitales;
            event.target.appendChild(signosVitalesInput);

            let form = event.target;
            let formData = new FormData(form);

            document.querySelectorAll('input[type="number"][data-producto-id]').forEach(input => {
                let checkbox = document.querySelector(`input[type="checkbox"][value="${input.dataset.productoId}"]`);
                if (!checkbox.checked) {
                    formData.append(input.name, 0);
                }
            });

            fetch(form.action, {
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
                    data.detalleCostos.forEach(detalle => {
                        if (detalle.tipo === 'servicio') {
                            detalles += `${detalle.nombre}: $${parseFloat(detalle.precio).toFixed(2)}<br>`;
                        } else {
                            detalles += `${detalle.nombre} (Cantidad: ${detalle.cantidad}): $${parseFloat(detalle.precio).toFixed(2)}<br>`;
                        }
                    });
                    detalles += `Costo base de la consulta: $100.00<br>`;
                    detalles += `<strong>Total a pagar: $${data.totalPagar.toFixed(2)}</strong>`;

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

        function actualizarTotal() {
            let total = 100;
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

        function toggleCantidad(checkbox) {
            const cantidadInput = checkbox.parentElement.querySelector('input[type="number"]');
            if (checkbox.checked) {
                cantidadInput.disabled = false;
                cantidadInput.value = '';
            } else {
                cantidadInput.disabled = true;
                cantidadInput.value = '';
            }
            actualizarTotal();
        }

        actualizarTotal();
    </script>
</x-app-layout>

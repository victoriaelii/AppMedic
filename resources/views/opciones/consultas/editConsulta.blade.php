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
                    <form id="editConsultasForm" method="POST" action="{{ route('consultas.update', $consulta->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6 text-center">
                            <h2 class="text-2xl font-semibold text-gray-800">Editar Consulta</h2>
                            <p class="text-lg text-gray-600">Paciente: {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}</p>
                        </div>

                        <!-- Motivo de la Consulta -->
                        <div class="mb-6">
                            <label for="motivo_consulta" class="block text-gray-700 font-medium">Motivo de Consulta:</label>
                            <textarea name="motivo_consulta" id="motivo_consulta" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('motivo_consulta', $consulta->motivo_consulta) }}</textarea>
                        </div>

                        <!-- Signos Vitales -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Signos Vitales:</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="talla" class="block text-gray-700 font-medium">Talla (m):</label>
                                    <input type="number" step="0.01" name="talla" id="talla" value="{{ old('talla', $signosVitales['talla'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="temperatura" class="block text-gray-700 font-medium">Temperatura (°C):</label>
                                    <input type="number" step="0.1" name="temperatura" id="temperatura" value="{{ old('temperatura', $signosVitales['temperatura'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="saturacion" class="block text-gray-700 font-medium">Saturación de oxígeno (%):</label>
                                    <input type="number" name="saturacion" id="saturacion" value="{{ old('saturacion', $signosVitales['saturacion'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="frecuencia_cardiaca" class="block text-gray-700 font-medium">Frecuencia cardíaca (bpm):</label>
                                    <input type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca" value="{{ old('frecuencia_cardiaca', $signosVitales['frecuencia_cardiaca'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="peso" class="block text-gray-700 font-medium">Peso (kg):</label>
                                    <input type="number" step="0.1" name="peso" id="peso" value="{{ old('peso', $signosVitales['peso'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="tension_arterial" class="block text-gray-700 font-medium">Tensión arterial (mm/Hg):</label>
                                    <input type="text" name="tension_arterial" id="tension_arterial" value="{{ old('tension_arterial', $signosVitales['tension_arterial'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                        
                        
                        

                        <!-- Notas del Padecimiento -->
                        <div class="mb-6">
                            <label for="notas_padecimiento" class="block text-gray-700 font-medium">Notas del Padecimiento:</label>
                            <textarea name="notas_padecimiento" id="notas_padecimiento" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('notas_padecimiento', $consulta->notas_padecimiento) }}</textarea>
                        </div>

                        <!-- Diagnóstico -->
                        <div class="mb-6">
                            <label for="diagnostico" class="block text-gray-700 font-medium">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                        </div>

                        <!-- Alergias -->
                        <div class="mb-6">
                            <label for="alergias" class="block text-gray-700 font-medium">Alergias:</label>
                            <textarea name="alergias" id="alergias" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('alergias', $consulta->alergias) }}</textarea>
                        </div>

                        <!-- Examen Físico -->
                        <div class="mb-6">
                            <label for="examen_fisico" class="block text-gray-700 font-medium">Examen Físico:</label>
                            <textarea name="examen_fisico" id="examen_fisico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('examen_fisico', $consulta->examen_fisico) }}</textarea>
                        </div>

                        <!-- Pronóstico -->
                        <div class="mb-6">
                            <label for="pronostico" class="block text-gray-700 font-medium">Pronóstico:</label>
                            <textarea name="pronostico" id="pronostico" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('pronostico', $consulta->pronostico) }}</textarea>
                        </div>

                        <!-- Receta -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium text-lg">
                                <i class="fas fa-prescription-bottle-alt"></i> Receta
                            </label>
                            <p class="text-gray-600">Ingresa la siguiente información para recetar un medicamento</p>

                            <div id="recetaFields">
                                @if(is_array($receteItems) && count($receteItems) > 0)
                                    @foreach($receteItems as $item)
                                        @if(is_array($item))
                                            <div class="grid grid-cols-5 gap-4 receta-item">
                                                <input type="text" name="medicacion[]" placeholder="Medicación" value="{{ old('medicacion[]', $item['medicacion']) }}" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required />
                                                <input type="number" name="cantidad[]" placeholder="Cantidad" value="{{ old('cantidad[]', $item['cantidad']) }}" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"  required/>
                                                <input type="text" name="frecuencia[]" placeholder="Frecuencia" value="{{ old('frecuencia[]', $item['frecuencia']) }}" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required />
                                                <input type="text" name="duracion[]" placeholder="Duración" value="{{ old('duracion[]', $item['duracion']) }}" class="col-span-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required />
                                                <button type="button" class="delete-button text-red-600 mt-2" onclick="removeRecetaItem(this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 26 26">
                                                        <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
                                                    </svg>
                                                </button>
                                    
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            
                            <button type="button" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md" id="addRecetaButton">
                                Agregar medicamento
                            </button>

                            <!-- Campo para agregar notas generales de la receta -->
                            <div class="mt-4">
                                <label for="notas_receta" class="block text-gray-700 font-medium">Agregar notas:</label>
                                <textarea name="notas_receta" id="notas_receta" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('notas_receta', $receteItems['notas'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="plan" class="block text-gray-700 font-medium">Plan de Tratamiento:</label>
                            <textarea name="plan" id="plan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('plan', $consulta->plan) }}</textarea>
                        </div>

                        <!-- Servicios y Productos -->
                        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-medium">Servicios:</label>
                                @foreach ($servicios as $servicio)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" class="mr-2" data-precio="{{ $servicio->precio }}" onchange="actualizarTotal()" @if($consulta->servicios->contains($servicio->id)) checked @endif>
                                        <label>{{ $servicio->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-medium">Productos:</label>
                                @foreach ($productos as $producto)
                                    @php
                                        $productoConsulta = $consulta->productos->where('id', $producto->id)->first();
                                        $cantidad = $productoConsulta ? $productoConsulta->pivot->cantidad : null;
                                    @endphp
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}" class="mr-2" onclick="toggleCantidad(this)" data-precio="{{ $producto->precio }}" onchange="actualizarTotal()" @if($cantidad) checked @endif>
                                        <label>{{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}</label>
                                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" min="1" max="{{ $producto->cantidad }}" class="ml-4 p-2 border rounded-md w-20" data-producto-id="{{ $producto->id }}" @if(!$cantidad) disabled @endif value="{{ old('cantidad[' . $producto->id . ']', $cantidad) }}">
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
                                    <option value="{{ $enfermera->id }}" @if($consulta->enfermera_id == $enfermera->id) selected @endif>{{ $enfermera->nombres }} {{ $enfermera->apepat }} ({{ $enfermera->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total a pagar -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium">Total a Pagar:</label>
                            <input type="text" id="totalPagar" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" readonly value="{{ old('totalPagar', $consulta->totalPagar) }}">
                        </div>

                        <!-- Botón para actualizar la consulta -->
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition text-lg font-medium">Actualizar Consulta</button>
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

        document.getElementById('editConsultasForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let form = event.target;
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Consulta actualizada correctamente',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = "{{ route('consultas.porConsultar') }}"; // Ajusta esta ruta según necesites
                    });
                } else {
                    throw new Error(data.error || 'Error al actualizar la consulta');
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




        document.querySelectorAll('input[type="number"][data-producto-id]').forEach(input => {
            input.addEventListener('input', actualizarTotal); // Actualiza total cuando cambie la cantidad
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

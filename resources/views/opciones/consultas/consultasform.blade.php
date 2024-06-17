<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Formulario de Consultas</h1>
        <form>
            <!-- Selección de Cita -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cita">
                    Seleccione una Cita
                </label>
                <select id="cita" name="cita" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Seleccione una cita</option>
                    <!-- Opciones de citas - aquí se mostrarían dinámicamente las citas disponibles -->
                </select>
            </div>

            <!-- Diagnóstico -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="diagnostico">
                    Diagnóstico
                </label>
                <textarea id="diagnostico" name="diagnostico" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <!-- Receta -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="receta">
                    Receta
                </label>
                <textarea id="receta" name="receta" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <!-- Signos Vitales -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="signos_vitales">
                    Signos Vitales
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" id="talla" name="talla" placeholder="Talla" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" id="peso" name="peso" placeholder="Peso" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" id="temperatura" name="temperatura" placeholder="Temperatura" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" id="saturacion" name="saturacion" placeholder="Saturación de Oxígeno" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" id="presion" name="presion" placeholder="Presión Arterial" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" id="frecuencia" name="frecuencia" placeholder="Frecuencia Cardíaca" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <!-- Motivo de la Consulta -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="motivo">
                    Motivo de la Consulta
                </label>
                <textarea id="motivo" name="motivo" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <!-- Notas de Padecimiento -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="notas">
                    Notas de Padecimiento
                </label>
                <textarea id="notas" name="notas" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <!-- Examen Físico -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="examen_fisico">
                    Examen Físico
                </label>
                <textarea id="examen_fisico" name="examen_fisico" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <!-- Pronóstico -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pronostico">
                    Pronóstico
                </label>
                <textarea id="pronostico" name="pronostico" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>


            <!-- Agregar Servicios -->
            <div class="mb-4">
                <button type="button" class="text-blue-500 hover:underline" onclick="toggleSection('serviciosSection', this)">+ Agregar servicios</button>
                <div id="serviciosSection" class="hidden mt-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Servicios Disponibles:</label>
                    <div>
                        <input type="checkbox" id="servicio1" name="servicio1" class="mr-2 leading-tight">
                        <label for="servicio1">Fisioterapia </label>
                    </div>
                    <div>
                        <input type="checkbox" id="servicio2" name="servicio2" class="mr-2 leading-tight">
                        <label for="servicio2">Vacunación </label>
                    </div>
                </div>
            </div>

            <!-- Agregar Productos -->
            <div class="mb-4">
                <button type="button" class="text-blue-500 hover:underline" onclick="toggleSection('productosSection', this)">+ Agregar productos</button>
                <div id="productosSection" class="hidden mt-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Productos Disponibles:</label>
                    <div>
                        <input type="checkbox" id="producto1" name="producto1" class="mr-2 leading-tight">
                        <label for="producto1">Termómetro Digital</label>
                    </div>
                    <div>
                        <input type="checkbox" id="producto2" name="producto2" class="mr-2 leading-tight">
                        <label for="producto2">Banda Elástica de Resistencia</label>
                    </div>
                </div>
            </div>

            <!-- Botón para Terminar Consulta -->
            <div class="flex items-center justify-center">
                <button class="bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    Terminar consulta
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(sectionId, button) {
            var section = document.getElementById(sectionId);
            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                button.textContent = button.textContent.replace('+', '-');
            } else {
                section.classList.add('hidden');
                button.textContent = button.textContent.replace('-', '+');
            }
        }
    </script>
</x-app-layout>

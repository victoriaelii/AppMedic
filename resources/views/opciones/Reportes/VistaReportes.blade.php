<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor interior -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados, con fondo blanco semitransparente -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <!-- Contenido interior -->
                <div class="p-6 text-gray-900">
                    <!-- Título principal -->
                    <h1 class="font-semibold text-2xl mb-6 text-gray-800 uppercase">REPORTE DE VENTAS</h1>

                    <!-- Tabla de productos vendidos -->
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full text-left text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b text-left" style="background-color: rgba(255, 255, 255, 0.7);">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-gray-700 text-lg">Producto</th>
                                    <th class="px-6 py-4 text-right font-semibold text-gray-700 text-lg">Precio Unitario (MXN)</th>
                                    <th class="px-6 py-4 text-right font-semibold text-gray-700 text-lg">Cantidad</th>
                                    <th class="px-6 py-4 text-right font-semibold text-gray-700 text-lg">Total (MXN)</th>
                                    <th class="px-6 py-4 font-semibold text-gray-700 text-lg">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventasDelDia as $venta)
                                    <tr class="border-b border-gray-300 hover:bg-gray-50" style="background-color: rgba(255, 255, 255, 0.8);">
                                        <td class="px-6 py-4">{{ $venta->nombre }}</td>
                                        <td class="px-6 py-4 text-right">${{ number_format($venta->precio, 2) }}</td>
                                        <td class="px-6 py-4 text-right">{{ $venta->cantidad }}</td>
                                        <td class="px-6 py-4 text-right">${{ number_format($venta->total, 2) }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($venta->fecha_vencimiento)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay ventas registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 border-t text-right" style="background-color: rgba(255, 255, 255, 0.7);">
                                <tr>
                                    <td colspan="4" class="text-end font-semibold">Total:</td>
                                    <td class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">${{ number_format($totalVentasProductos, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <!-- Sección similar para servicios -->
                        
                        <table class="min-w-full text-left text-sm bg-white border-collapse mt-4" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b text-left" style="background-color: rgba(255, 255, 255, 0.7);">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-gray-700 text-lg">Servicio</th>
                                    <th class="px-6 py-4 text-right font-semibold text-gray-700 text-lg">Precio Unitario (MXN)</th>
                                    <th class="px-6 py-4 text-right font-semibold text-gray-700 text-lg">Total (MXN)</th>
                                    <th class="px-6 py-4 font-semibold text-gray-700 text-lg">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviciosDelDia as $servicio)
                                    <tr class="border-b border-gray-300 hover:bg-gray-50" style="background-color: rgba(255, 255, 255, 0.8);">
                                        <td class="px-6 py-4">{{ $servicio->nombre }}</td>
                                        <td class="px-6 py-4 text-right">${{ number_format($servicio->precio, 2) }}</td>
                                        <td class="px-6 py-4 text-right">${{ number_format($servicio->total, 2) }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($servicio->fecha_vencimiento)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay servicios vendidos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 border-t text-right" style="background-color: rgba(255, 255, 255, 0.7);">
                                <tr>
                                    <td colspan="3" class="text-end font-semibold">Total:</td>
                                    <td class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">${{ number_format($totalVentasServicios, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>

                    <!-- Mostrar el total de todas las ventas -->
                    @if($ventasDelDia->isNotEmpty() || $serviciosDelDia->isNotEmpty())
                        <div class="mt-10 text-end">
                            <h3 class="text-xl font-semibold text-gray-900">Total: ${{ number_format($totalVentas, 2) }}</h3>
                        </div>
                    @endif

                    <!-- Botón para descargar el reporte del día en PDF -->
                    <div class="text-end my-10">
                        <a href="{{ route('reportes.descargarDiaPdf') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl shadow-xl hover:bg-blue-700 transition">Descargar Reporte del Día en PDF</a>
                    </div>

                    <!-- Formulario para seleccionar mes y año para el reporte -->
                    <h2 class="text-sm font-semibold text-gray-800 uppercase">Generar Reporte Mensual</h2>
                    <form action="{{ route('reportes.generar') }}" method="POST" class="text-left space-y-6">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="w-1/2">
                                <label for="mes" class="block text-gray-700 font-medium">Seleccione Mes:</label>
                                <select name="mes" id="mes" class="block w-full mt-2 rounded border-gray-300 shadow-sm">
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label for="anio" class="block text-gray-700 font-medium">Seleccione Año:</label>
                                <select name="anio" id="anio" class="block w-full mt-2 rounded border-gray-300 shadow-sm">
                                    @for($year = date('Y'); $year >= 2000; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">Generar Reporte</button>
                    </form>

                    <!-- Botón para descargar el reporte del mes en PDF -->
                    <div class="text-end my-10">
                        <form action="{{ route('reportes.descargarMensualPdf') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mes" value="{{ request('mes') }}">
                            <input type="hidden" name="anio" value="{{ request('anio') }}">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl shadow-md hover:bg-blue-700 transition">Descargar Reporte Mensual en PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <!-- Contenedor principal -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <!-- Encabezado de la sección -->
                        <div class=" flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Consultas</h1>
                        </div>

                        <!-- Formulario de búsqueda y filtrado -->
                        <form method="GET" action="{{ route('consultas.porConsultar') }}" class="mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                <div>
                                    <input type="text" name="nombre" placeholder="Buscar por nombre o apellidos" value="{{ request('nombre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Filtrar por estado</option>
                                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en curso" {{ request('estado') == 'en curso' ? 'selected' : '' }}>En curso</option>
                                        <option value="finalizada" {{ request('estado') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                    </select>
                                </div>
                                        <!-- Campo de fecha -->
                                <div>
                                    <input type="date" name="fecha" value="{{ request('fecha') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Buscar</button>
                                    <a href="{{ route('consultas.porConsultar') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Limpiar</a>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla de citas -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b text-center" style="background-color: rgba(255, 255, 255, 0.6); border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Fecha</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Hora</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Paciente</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Total a Pagar</th>
                                    <th scope="col" class="px-6 py-4 text-center font-semibold text-gray-700 text-lg">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center" style="background-color: rgba(255, 255, 255, 0.6);">
                                @if($citas->isEmpty())
                                    <!-- Mostrar un mensaje si no hay citas según el estado seleccionado -->
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            @if(request('estado') == 'en curso')
                                                No hay consultas en curso.
                                            @elseif(request('estado') == 'finalizada')
                                                No hay consultas finalizadas.
                                            @else
                                                No hay consultas pendientes.
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @foreach($citas as $cita)
                                        @if(auth()->user()->rol == 'admin')
                                            @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                                <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                                    <td class="px-6 py-4 text-center">{{ $cita->fecha }}</td>
                                                    <td class="px-6 py-4 text-center">{{ $cita->hora }}</td>
                                                    <td class="px-6 py-4 text-center">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                                    <td class="px-6 py-4 text-center">
                                                        ${{ number_format($cita->consulta->totalPagar, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 flex items-center justify-center space-x-2">
                                                        <a href="{{ route('consultas.edit', $cita->consulta->id) }}" class="text-green-600 hover:text-green-900 transition">
                                                            <!-- Ícono de editar -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <button type="button" class="   ver-detalles-btn" data-consulta="{{ $cita->consulta }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="color: #00BFFF;"> <!-- #00BFFF es el código de color celeste -->
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                            </svg>
                                                        </button>


                                                        <form action="{{ route('consultas.eliminarConsulta', $cita->consulta->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            <button type="button" class="text-red-600 hover:text-red-900 transition eliminar-btn">
                                                                <!-- Ícono de eliminar -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>


                                                    </td>
                                                </tr>
                                            @endif
                                        @elseif(auth()->user()->rol == 'medico')
                                            <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                                <td class="px-6 py-4">{{ $cita->fecha }}</td>
                                                <td class="px-6 py-4">{{ $cita->hora }}</td>
                                                <td class="px-6 py-4">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                                <td class="px-6 py-4">
                                                    @if($cita->consulta)
                                                        @if($cita->consulta->estado == 'en curso')
                                                            {{ __('En curso') }}
                                                        @else
                                                            ${{ number_format($cita->consulta->totalPagar, 2) }}
                                                        @endif
                                                    @else
                                                        {{ __('Pendiente') }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 flex items-center justify-center space-x-2">
                                                    @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 30 30" fill="green">
                                                            <!-- Ícono de consulta finalizada -->
                                                            <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M21.707,12.707l-7.56,7.56 c-0.188,0.188-0.442,0.293-0.707,0.293s-0.52-0.105-0.707-0.293l-3.453-3.453c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0 l2.746,2.746l6.853-6.853c0.391-0.391,1.023-0.391,1.414,0S22.098,12.316,21.707,12.707z"></path>
                                                        </svg>
                                                        <!-- Botón 'Ver' -->
                                                        <!-- Botón 'Ver' con ícono -->
                                                        <button type="button" class="   ver-detalles-btn" data-consulta="{{ $cita->consulta }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="color: #00BFFF;"> <!-- #00BFFF es el código de color celeste -->
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                            </svg>
                                                        </button>

                                                    @else
                                                        @if($cita->consulta)
                                                            <a href="{{ route('consultas.edit', $cita->consulta->id) }}">
                                                                <button class="text-green-600 hover:text-green-900 transition">
                                                                    <!-- Ícono de editar -->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                    </svg>
                                                                </button>
                                                            </a>
                                                            <form action="{{ route('consultas.terminar', $cita->consulta->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="text-red-500 px-4 py-2 rounded-md hover:bg-red-200 transition">
                                                                    Terminar
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('consultas.form', $cita->id) }}">
                                                                <button class="bg-green-100 text-green-500 px-4 py-2 rounded-md hover:bg-green-200 transition">
                                                                    Ir a consulta
                                                                </button>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $citas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script para manejar la confirmación de eliminación y mostrar detalles -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.eliminar-btn');
            const verDetallesButtons = document.querySelectorAll('.ver-detalles-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "No podrás revertir esto",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            verDetallesButtons.forEach(button => {
                button.addEventListener('click', function () {
                    try {
                        const consulta = JSON.parse(this.dataset.consulta);

                        const totalPagar = Number(consulta.totalPagar);

                        Swal.fire({
                            title: '<strong style="font-size: 20px; color: #333;">Detalles de la consulta</strong>',
                            html: `
                                <div style="text-align: left; font-size: 14px; line-height: 1.6; color: #555;">
                                    <p><strong>Motivo de Consulta:</strong> ${consulta.motivo_consulta}</p>
                                    <p><strong>Signos Vitales:</strong></p>
                                    <ul style="list-style-type: disc; padding-left: 20px;">
                                        ${consulta.signos_vitales.split(',').map(signo => `<li>${signo.trim()}</li>`).join('')}
                                    </ul>
                                    <p><strong>Notas del padecimiento:</strong> ${consulta.notas_padecimiento}</p>
                                    <p><strong>Diagnóstico:</strong> ${consulta.diagnostico}</p>
                                    <p><strong>Alergias:</strong> ${consulta.alergias}</p>
                                    <p><strong>Examen Físico:</strong> ${consulta.examen_fisico}</p>
                                    <p><strong>Receta:</strong></p>
                                    <ul style="list-style-type: disc; padding-left: 20px;">
                                        ${consulta.recete.split('|').map(receta => `<li>${receta.trim()}</li>`).join('')}
                                    </ul>
                                    <p><strong>Pronóstico:</strong> ${consulta.pronostico}</p>
                                    <p><strong>Plan de Tratamiento:</strong> ${consulta.plan}</p>
                                    <p><strong>Servicios Adquiridos:</strong></p>
                                    <ul style="list-style-type: none; padding-left: 0;">
                                        ${consulta.servicios.map(servicio => `<li>• ${servicio.nombre}: <span style="float: right;">$${Number(servicio.precio).toFixed(2)}</span></li>`).join('')}
                                    </ul>
                                    <p><strong>Productos:</strong></p>
                                    <ul style="list-style-type: none; padding-left: 0;">
                                        ${consulta.productos.map(producto => `<li>• ${producto.nombre} (Cantidad: ${producto.pivot.cantidad}): <span style="float: right;">$${(producto.pivot.cantidad * producto.precio).toFixed(2)}</span></li>`).join('')}
                                    </ul>
                                    <p><strong>Enfermera:</strong> ${consulta.enfermera ? `${consulta.enfermera.nombres} ${consulta.enfermera.apepat}` : 'No asignada'}</p>
                                    <hr style="border-top: 1px solid #ccc; margin: 10px 0;">
                                    <p><strong>Total a Pagar:</strong> <span style="font-size: 18px; color: #333;">$${totalPagar.toFixed(2)}</span></p>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Ok',
                            width: '500px',
                            padding: '1.5em',
                            background: '#fefefe',
                            customClass: {
                                popup: 'swal2-border-radius',
                            }
                        });
                    } catch (error) {
                        console.error("Error al mostrar los detalles de la consulta:", error);
                    }
                });
            });
        });



    </script>
</x-app-layout>

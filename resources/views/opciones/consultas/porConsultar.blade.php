<x-app-layout>
    <!-- Contenedor principal -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <!-- Encabezado de la sección -->
                        <div class="flex my-4 items-center justify-between">
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
                                                        <a href="{{ route('consultas.edit', $cita->consulta->id) }}" class="text-blue-600 hover:text-blue-900 transition">
                                                            <!-- Ícono de editar -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50" fill="currentColor">
                                                                <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875 44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375 6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z"></path>
                                                            </svg>
                                                        </a>
                                                                                                                <!-- Botón 'Ver' -->
                                                                                                                <button type="button" class="   ver-detalles-btn" data-consulta="{{ $cita->consulta }}">
                                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="color: #00BFFF;"> <!-- #00BFFF es el código de color celeste -->
                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                                                                                    </svg>
                                                                                                                </button>


                                                        <form action="{{ route('consultas.eliminarConsulta', $cita->consulta->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            <button type="button" class="text-red-600 hover:text-red-900 transition eliminar-btn">
                                                                <!-- Ícono de eliminar -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 26 26">
                                                                    <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
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
                                                                <button class="text-blue-600 hover:text-blue-900 transition">
                                                                    <!-- Ícono de editar -->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50" fill="currentColor">
                                                                        <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875 44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375 6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z"></path>
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

    <!-- Incluir SweetAlert -->
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
                        // Asegúrate de que el dataset tenga un JSON válido
                        const consulta = JSON.parse(this.dataset.consulta);

                        // Asegúrate de que totalPagar sea un número antes de usar toFixed
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

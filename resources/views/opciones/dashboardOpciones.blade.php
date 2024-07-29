<x-app-layout>
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Pacientes</h1>
                            <a href="{{ route('agregarPaciente', ['redirect_to' => 'dashboardOpciones']) }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Registrar Paciente') }}
                                </button>
                            </a>
                        </div>
                        <form method="GET" action="{{ route('dashboardOpciones') }}" class="flex mb-4 space-x-4">
                            <input type="text" name="nombre" placeholder="Nombre del Paciente" class="border border-gray-300 p-2 rounded-md" value="{{ request('nombre') }}">
                            <input type="date" name="fechanac" class="border border-gray-300 p-2 rounded-md" value="{{ request('fechanac') }}">
                            <input type="email" name="correo" placeholder="Correo del Paciente" class="border border-gray-300 p-2 rounded-md" value="{{ request('correo') }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Buscar</button>
                            <a href="{{ route('dashboardOpciones') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Limpiar</a>
                        </form>
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Nombres</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Correo</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Teléfono</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Código</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                @foreach($pacientes as $paciente)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-left">{{ $paciente->nombres }}</td>
                                        <td class="px-6 py-4 text-left">{{ $paciente->apepat }}</td>
                                        <td class="px-6 py-4 text-left">{{ $paciente->apemat }}</td>
                                        <td class="px-6 py-4 text-left">{{ $paciente->fechanac }}</td>
                                        <td class="px-6 py-4 text-left">{{ $paciente->correo }}</td>
                                        <td class="px-6 py-4 text-left">{{ $paciente->telefono }}</td>
                                        <td class="px-6 py-4 text-left">
                                            @if($paciente->codigo)
                                                {{ $paciente->codigo }}
                                            @else
                                                <form action="{{ route('pacientes.generarCodigo', $paciente->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-700 transition">Generar código</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left flex items-center space-x-2">
                                            <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-600 hover:text-blue-900 transition">Editar</a>
                                            @if(Auth::user()->rol != 'secretaria')
                                                <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 transition">Eliminar</button>
                                                </form>
                                            @endif
                                            @if($paciente->citas->contains(fn($cita) => $cita->consulta && $cita->consulta->estado == 'finalizada'))
                                                <a href="{{ route('historialMedico.show', $paciente->id) }}" class="text-green-600 hover:text-green-900 transition">Historial</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($pacientes->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay pacientes registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

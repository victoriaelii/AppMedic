<x-app-layout>
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen py-12" style="background-image: url('https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <!-- Contenedor interior -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja con sombra y bordes redondeados, con fondo blanco semitransparente -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="background-color: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px);">
                <!-- Contenido interior -->
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <!-- Encabezado de la sección -->
                        <div class="flex my-4 items-center justify-between">
                            <h1 class="text-2xl font-semibold text-gray-800 uppercase">Lista de Productos</h1>
                            <!-- Botón para agregar nuevo producto -->
                            <a href="{{ route('productos.agregar') }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('Agregar Producto') }}
                                </button>
                            </a>
                        </div>
                        <!-- Tabla de productos -->
                        <table class="min-w-full text-center text-sm bg-white border-collapse" style="background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px);">
                            <!-- Cabecera de la tabla -->
                            <thead class="bg-gray-50 border-b" style="background-color: rgba(255, 255, 255, 0.6);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Nombre</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Precio</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Cantidad</th>
                                    <th scope="col" class="px-6 py-4 text-left font-semibold text-gray-700 text-lg">Acciones</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla -->
                            <tbody class="bg-white divide-y divide-gray-200" style="background-color: rgba(255, 255, 255, 0.6);">
                                <!-- Iterar sobre los productos y mostrar cada uno en una fila -->
                                @foreach($productos as $producto)
                                    <tr class="hover:bg-gray-100 transition" style="background-color: rgba(255, 255, 255, 0.6);">
                                        <td class="px-6 py-4 text-left">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4 text-left">{{ $producto->precio }}</td>
                                        <td class="px-6 py-4 text-left">{{ $producto->cantidad }}</td>
                                        <td class="px-6 py-4 text-left flex items-center space-x-2">
                                            <!-- Enlace para editar el producto -->
                                            <a href="{{ route('productos.editar', $producto->id) }}" class="text-blue-600 hover:text-blue-900 transition">Editar</a>
                                            <!-- Botón para eliminar el producto con SweetAlert -->
                                            <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" class="inline-block form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition eliminar-btn">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay productos registrados -->
                        @if($productos->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay productos registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.form-eliminar');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const button = form.querySelector('.eliminar-btn');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>

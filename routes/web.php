<?php

use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Ruta para la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Grupo de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas para la gestión del perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para la gestión de pacientes
    Route::post('/pacientes/store', [SecretariaController::class, 'storePacientes'])->name('pacientes.store');
    Route::get('/agregarPaciente', function () {
        return view('opciones.pacientes.agregarPaciente');
    })->name('agregarPaciente');
    Route::get('/opciones/dashboardOpciones', [SecretariaController::class, 'mostrarPacientes'])->name('dashboardOpciones');
    Route::get('/opciones/pacientes/editar/{id}', [SecretariaController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::patch('/opciones/pacientes/editar/{id}', [SecretariaController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/opciones/pacientes/eliminar/{id}', [SecretariaController::class, 'eliminarPaciente'])->name('pacientes.eliminar');

    // Rutas para la gestión de productos
    Route::get('/opciones/productos/agregar', [SecretariaController::class, 'crearProducto'])->name('productos.agregar');
    Route::post('/opciones/productos/store', [SecretariaController::class, 'storeProductos'])->name('productos.store');
    Route::get('/opciones/productos/editar/{id}', [SecretariaController::class, 'editarProducto'])->name('productos.editar');
    Route::patch('/opciones/productos/editar/{id}', [SecretariaController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/opciones/productos/eliminar/{id}', [SecretariaController::class, 'eliminarProducto'])->name('productos.eliminar');
    Route::get('/opciones/productos', [SecretariaController::class, 'mostrarProductos'])->name('productos');

    // Rutas para la gestión de citas
    Route::get('/opciones/citas', [SecretariaController::class, 'mostrarCitas'])->name('citas');
    Route::post('/opciones/citas/store', [SecretariaController::class, 'storeCitas'])->name('citas.store');
    Route::get('/opciones/citas/agregar', [SecretariaController::class, 'crearCita'])->name('citas.agregar');
    Route::get('/opciones/citas/editar/{id}', [SecretariaController::class, 'editarCita'])->name('citas.editar');
    Route::patch('/opciones/citas/editar/{id}', [SecretariaController::class, 'updateCita'])->name('citas.update');
    Route::delete('/opciones/citas/eliminar/{id}', [SecretariaController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::get('/opciones/citas/agregar', [SecretariaController::class, 'crearCita'])->name('crearCita');
    Route::get('/opciones/citas/tablaCitas', [SecretariaController::class, 'tablaCitas'])->name('tablaCitas');
    Route::get('/buscarPaciente', [SecretariaController::class, 'buscarPaciente']);

    // Rutas para la gestión de médicos
    Route::get('/opciones/medicos', [SecretariaController::class, 'mostrarMedicos'])->name('medicos');
    Route::post('/opciones/medicos/store', [SecretariaController::class, 'storeMedicos'])->name('medicos.store');
    Route::get('/opciones/medicos/agregar', [SecretariaController::class, 'crearMedico'])->name('medicos.agregar');
    Route::get('/opciones/medicos/editar/{id}', [SecretariaController::class, 'editarMedico'])->name('medicos.editar');
    Route::patch('/opciones/medicos/editar/{id}', [SecretariaController::class, 'updateMedico'])->name('medicos.update');
    Route::delete('/opciones/medicos/eliminar/{id}', [SecretariaController::class, 'eliminarMedico'])->name('medicos.eliminar');

    // Rutas para la gestión de servicios
    Route::get('/opciones/servicios', [SecretariaController::class, 'mostrarServicios'])->name('servicios');
    Route::post('/opciones/servicios/store', [SecretariaController::class, 'storeServicios'])->name('servicios.store');
    Route::get('/opciones/servicios/agregar', [SecretariaController::class, 'crearServicio'])->name('servicios.agregar');
    Route::get('/opciones/servicios/editar/{id}', [SecretariaController::class, 'editarServicio'])->name('servicios.editar');
    Route::patch('/opciones/servicios/editar/{id}', [SecretariaController::class, 'updateServicio'])->name('servicios.update');
    Route::delete('/opciones/servicios/eliminar/{id}', [SecretariaController::class, 'eliminarServicio'])->name('servicios.eliminar');

    // CONSULTAS
    Route::get('/opciones/consultas/porConsultar', [SecretariaController::class, 'porConsultar'])->name('consultas.porConsultar');
    Route::get('/consultasform/{id}', [SecretariaController::class, 'showForm'])->name('consultas.form');
    Route::post('/opciones/consultas/store', [SecretariaController::class, 'storeConsultas'])->name('consultas.store');
    Route::get('/consultas/edit/{id}', [SecretariaController::class, 'editConsultas'])->name('consultas.edit');
    Route::patch('/consultas/update/{id}', [SecretariaController::class, 'updateConsultas'])->name('consultas.update');
    Route::patch('/consultas/terminar/{id}', [SecretariaController::class, 'terminarConsulta'])->name('consultas.terminar');



    // Ruta para mostrar el historial médico
    Route::get('/historial-medico/{id}', [SecretariaController::class, 'mostrarHistorialMedico'])->name('historialMedico.show');
    // Ruta para descargar el historial médico en PDF
    Route::get('/historial-medico/{id}/pdf', [SecretariaController::class, 'descargarHistorialMedicoPdf'])->name('historialMedico.pdf');

});

require __DIR__.'/auth.php';

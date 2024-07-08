<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Consultas; 

// Controlador que maneja las funciones de la secretaria
class SecretariaController extends Controller
{
    // Muestra la vista principal del usuario secretaria
    public function index()
    {
        return view('/UsuarioSecretaria');
    }

    // Muestra el formulario de consultas
    public function consultasForm()
    {
        return view('opciones.consultas.consultasform');
    }

    // Muestra las citas pendientes por consultar
    public function porConsultar()
    {
        // Obtiene las citas junto con la información del paciente, médico y consulta asociada
        $citas = Citas::with(['paciente', 'medico', 'consulta'])->paginate(10);
        return view('opciones.consultas.porConsultar', compact('citas'));
    }
    
    // Muestra el formulario para una consulta específica
    public function showForm($id)
    {
        $cita = Citas::findOrFail($id);
        $servicios = Servicio::where('activo', 'si')->get();
        $productos = Productos::where('activo', 'si')->get();
        return view('opciones.consultas.consultasform', compact('cita', 'servicios', 'productos'));
    }

    // Guarda una nueva consulta en la base de datos
    public function storeConsultas(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'diagnostico' => 'required|string',
            'recete' => 'required|string',
            'signos_vitales' => 'nullable|string',
            'motivo_consulta' => 'nullable|string',
            'notas_padecimiento' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'pronostico' => 'nullable|string',
            'plan' => 'nullable|string',
            'alergias' => 'nullable|string',
            'servicios' => 'nullable|array',
            'productos' => 'nullable|array',
        ]);

        // Crea la consulta con los datos del formulario
        $consulta = Consultas::create([
            'cita_id' => $request->cita_id,
            'diagnostico' => $request->diagnostico,
            'recete' => $request->recete,
            'signos_vitales' => $request->signos_vitales,
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
            'examen_fisico' => $request->examen_fisico,
            'pronostico' => $request->pronostico,
            'plan' => $request->plan,
            'alergias' => $request->alergias,
            'totalPagar' => 100, // Precio base de la consulta
            'usuariomedicoid' => auth()->user()->id,
        ]);

        $totalPagar = 100; // Precio base de la consulta
        $detalleCostos = [];

        // Si hay servicios seleccionados, se agregan a la consulta y se suman al total
        if ($request->has('servicios')) {
            $servicios = Servicio::whereIn('id', $request->servicios)->get();
            foreach ($servicios as $servicio) {
                $consulta->servicios()->attach($servicio->id);
                $totalPagar += $servicio->precio;
                $detalleCostos[] = ['nombre' => $servicio->nombre, 'precio' => $servicio->precio];
            }
        }

        // Si hay productos seleccionados, se agregan a la consulta y se suman al total
        if ($request->has('productos')) {
            $productos = Productos::whereIn('id', $request->productos)->get();
            foreach ($productos as $producto) {
                $consulta->productos()->attach($producto->id);
                $totalPagar += $producto->precio;
                $detalleCostos[] = ['nombre' => $producto->nombre, 'precio' => $producto->precio];
            }
        }

        // Actualiza el total a pagar en la consulta
        $consulta->update(['totalPagar' => $totalPagar]);

        // Retorna una respuesta JSON con el estado, los detalles de costos y el total a pagar
        return response()->json(['status' => true, 'detalleCostos' => $detalleCostos, 'totalPagar' => $totalPagar]);
    }

    // Muestra el formulario para editar una consulta
    public function editConsultas($id)
    {
        $consulta = Consultas::findOrFail($id);
        $servicios = Servicio::where('activo', 'si')->get();
        $productos = Productos::where('activo', 'si')->get();
        return view('opciones.consultas.editConsulta', compact('consulta', 'servicios', 'productos'));
    }
    
    // Actualiza una consulta en la base de datos
    public function updateConsultas(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'diagnostico' => 'required|string',
            'recete' => 'required|string',
            'signos_vitales' => 'nullable|string',
            'motivo_consulta' => 'nullable|string',
            'notas_padecimiento' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'pronostico' => 'nullable|string',
            'plan' => 'nullable|string',
            'alergias' => 'nullable|string',
            'servicios' => 'nullable|array',
            'productos' => 'nullable|array',
        ]);

        // Encuentra la consulta y la actualiza con los nuevos datos
        $consulta = Consultas::findOrFail($id);
        $consulta->update([
            'diagnostico' => $request->diagnostico,
            'recete' => $request->recete,
            'signos_vitales' => $request->signos_vitales,
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
            'examen_fisico' => $request->examen_fisico,
            'pronostico' => $request->pronostico,
            'plan' => $request->plan,
            'alergias' => $request->alergias,
        ]);

        // Sincroniza los servicios y productos seleccionados
        $consulta->servicios()->sync($request->servicios);
        $consulta->productos()->sync($request->productos);

        // Redirige a la página de consultas pendientes con un mensaje de éxito
        return redirect()->route('consultas.porConsultar')->with('status', 'Consulta actualizada correctamente');
    }
    
    // Guarda un nuevo paciente en la base de datos
    public function storePacientes(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes,correo',
            'telefono' => 'required|string|max:20',
        ]);

        // Crea el paciente con los datos del formulario
        Paciente::create($request->all());

        // Redirige a la vista de opciones de pacientes con un mensaje de éxito
        $redirect_to = $request->input('redirect_to', 'dashboardOpciones');
        return redirect()->route($redirect_to)->with('status', 'Paciente registrado correctamente');
    }

    // Muestra la lista de pacientes activos
    public function mostrarPacientes()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        return view('/opciones.dashboardOpciones', compact('pacientes'));
    }

    // Muestra el formulario para editar un paciente
    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('/opciones.pacientes.editarPaciente', compact('paciente'));
    }

    // Actualiza un paciente en la base de datos
    public function updatePaciente(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes,correo,' . $id,
            'telefono' => 'required|string|max:20',
        ]);

        // Encuentra el paciente y lo actualiza con los nuevos datos
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        // Redirige a la vista de opciones de pacientes con un mensaje de éxito
        return redirect()->route('dashboardOpciones')->with('status', 'Paciente actualizado correctamente');
    }

    // Elimina (desactiva) un paciente en la base de datos
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        // Redirige a la vista de opciones de pacientes con un mensaje de éxito
        return redirect()->route('dashboardOpciones')->with('status', 'Paciente eliminado correctamente');
    }

    // Muestra la lista de productos activos
    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('/opciones.productos.productos', compact('productos'));
    }

    // Guarda un nuevo producto en la base de datos
    public function storeProductos(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Crea el producto con los datos del formulario
        Productos::create($request->all());

        // Redirige a la vista de opciones de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo producto
    public function crearProducto()
    {
        return view('/opciones.productos.agregarProducto');
    }

    // Muestra el formulario para editar un producto
    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('/opciones.productos.editarProducto', compact('producto'));
    }

    // Actualiza un producto en la base de datos
    public function updateProducto(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Encuentra el producto y lo actualiza con los nuevos datos
        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        // Redirige a la vista de opciones de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Elimina (desactiva) un producto en la base de datos
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        // Redirige a la vista de opciones de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

    // Muestra la tabla de citas
    public function tablaCitas(Request $request)
    {
        $this->desactivarCitasPasadas();
    
        $now = Carbon::now('America/Mexico_City');
    
        $query = Citas::with(['paciente', 'medico'])
                      ->where('activo', 'si')
                      ->where(function ($query) use ($now) {
                          $query->where('fecha', '>', $now->toDateString())
                                ->orWhere(function ($query) use ($now) {
                                    $query->where('fecha', '=', $now->toDateString())
                                          ->where('hora', '>', $now->toTimeString());
                                });
                      });
    
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->whereHas('paciente', function ($query) use ($nombre) {
                $query->where('nombres', 'like', "%{$nombre}%")
                      ->orWhere('apepat', 'like', "%{$nombre}%")
                      ->orWhere('apemat', 'like', "%{$nombre}%");
            });
        }
    
        if ($request->filled('fecha')) {
            $fecha = $request->input('fecha');
            $query->whereDate('fecha', $fecha);
        }
    
        if ($request->filled('correo')) {
            $correo = $request->input('correo');
            $query->whereHas('paciente', function ($query) use ($correo) {
                $query->where('correo', 'like', "%{$correo}%");
            });
        }
    
        $citas = $query->orderBy('fecha')->orderBy('hora')->paginate(10);
    
        return view('opciones.citas.tablaCitas', compact('citas'));
    }
    
    // Desactiva las citas pasadas
    public function desactivarCitasPasadas()
    {
        $now = Carbon::now('America/Mexico_City');
    
        Citas::where(function ($query) use ($now) {
            $query->where('fecha', '<', $now->toDateString())
                  ->orWhere(function ($query) use ($now) {
                      $query->where('fecha', '=', $now->toDateString())
                            ->where('hora', '<', $now->toTimeString());
                  });
        })->where('activo', 'si')->update(['activo' => 'no']);
    }

    // Muestra las citas activas
    public function mostrarCitas()
    {
        $now = Carbon::now('America/Mexico_City');
        
        $citas = Citas::with(['paciente', 'medico'])
                      ->where(function ($query) use ($now) {
                          $query->where('fecha', '>', $now->toDateString())
                                ->orWhere(function ($query) use ($now) {
                                    $query->where('fecha', '=', $now->toDateString())
                                          ->where('hora', '>', $now->toTimeString());
                                });
                      })
                      ->where('activo', 'si')
                      ->get();
        
        return view('/opciones.citas.citas', compact('citas'));
    }

    // Guarda una nueva cita en la base de datos
    public function storeCitas(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->toDateString(),
            'hora' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:22:00',
            'pacienteid' => 'required|exists:pacientes,id',
            'medicoid' => 'required|exists:users,id',
        ]);
    
        $fecha = $request->input('fecha');
        $hora = $request->input('hora');
        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora, 'America/Mexico_City');
        $ahora = Carbon::now('America/Mexico_City');
    
        if ($fechaHoraCita->isPast()) {
            return back()->withErrors(['hora' => 'Hora pasada. Elige una hora futura.'])->withInput();
        }
    
        $existingAppointment = Citas::where('fecha', $request->fecha)
            ->where('pacienteid', $request->pacienteid)
            ->where('activo', 'si')
            ->first();
    
        if ($existingAppointment) {
            return back()->withErrors(['fecha' => 'El paciente ya tiene una cita activa agendada para esta fecha.'])->withInput();
        }
    
        $existingAppointmentSameHour = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('activo', 'si')
            ->first();
    
        if ($existingAppointmentSameHour) {
            return back()->withErrors(['hora' => 'Ya existe una cita activa a esta hora.'])->withInput();
        }
    
        Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'pacienteid' => $request->pacienteid,
            'medicoid' => $request->medicoid,
            'activo' => 'si',
        ]);
    
        $redirect_to = $request->input('redirect_to', 'tablaCitas');
        return redirect()->route($redirect_to)->with('status', 'Cita registrada correctamente');
    }
    
    // Muestra el formulario para agregar una nueva cita
    public function crearCita()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('opciones.citas.agregarCita', compact('pacientes', 'medicos'));
    }

    // Muestra el formulario para editar una cita
    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('/opciones.citas.editarCita', compact('cita', 'pacientes', 'medicos'));
    }
    // actualiz a cita
    public function updateCita(Request $request, $id)
    {
        // Formatea la hora a H:i
        $hora = date('H:i', strtotime($request->hora));
    
        // Valida los datos del formulario
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->toDateString(),
            'hora' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:22:00',
            'pacienteid' => 'required|exists:pacientes,id',
            'medicoid' => 'required|exists:users,id',
        ]);
    
        // Valida que la hora no sea pasada
        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $request->fecha . ' ' . $hora, 'America/Mexico_City');
        $ahora = Carbon::now('America/Mexico_City');
        if ($fechaHoraCita->isPast()) {
            return back()->withErrors(['hora' => 'Hora pasada. Elige una hora futura.'])->withInput();
        }
    
        // Validaciones adicionales para citas existentes
        $existingAppointment = Citas::where('fecha', $request->fecha)
            ->where('pacienteid', $request->pacienteid)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->first();
        if ($existingAppointment) {
            return back()->withErrors(['fecha' => 'El paciente ya tiene una cita activa agendada para esta fecha.'])->withInput();
        }
        $existingAppointmentSameHour = Citas::where('fecha', $request->fecha)
            ->where('hora', $hora)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->first();
        if ($existingAppointmentSameHour) {
            return back()->withErrors(['hora' => 'Ya existe una cita activa a esta hora.'])->withInput();
        }
    
        // Actualiza la cita
        $cita = Citas::findOrFail($id);
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $hora,
            'pacienteid' => $request->pacienteid,
            'medicoid' => $request->medicoid,
            'activo' => 'si',
        ]);
    
        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }
    
    
    // Elimina (desactiva) una cita en la base de datos
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->activo = 'no';
        $cita->save();
    
        return redirect()->route('tablaCitas')->with('status', 'Cita eliminada correctamente');
    }

    // Obtiene las citas activas y las devuelve en formato JSON para el calendario
    public function getCitasEventos()
    {
        $citas = Citas::with('paciente')->where('activo', 'si')->get();
        $eventos = [];
    
        foreach ($citas as $cita) {
            $eventos[] = [
                'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apepat,
                'start' => $cita->fecha . 'T' . $cita->hora,
                'paciente' => $cita->paciente->nombres . ' ' . $cita->paciente->apepat . ' ' . $cita->paciente->apemat,
            ];
        }
    
        return response()->json($eventos);
    }

    // Muestra la lista de médicos activos
    public function mostrarMedicos()
    {
        $medicos = User::whereIn('rol', ['medico', 'secretaria', 'colaborador'])
                        ->where('activo', 'si')
                        ->get();
        return view('/opciones.medicos.medicos', compact('medicos'));
    }

    // Guarda un nuevo médico en la base de datos
    public function storeMedicos(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'rol' => ['required', 'in:medico,secretaria,colaborador,admin'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->rol === 'medico' && User::where('rol', 'medico')->exists()) {
            return redirect()->back()->withInput()->with('error', 'No se pueden registrar más de un doctor');
        }

        // Crea el médico con los datos del formulario
        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        // Redirige a la vista de opciones de médicos con un mensaje de éxito
        return redirect()->route('medicos')->with('status', 'Médico registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo médico
    public function crearMedico()
    {
        return view('/opciones.medicos.agregarMedico');
    }

    // Muestra el formulario para editar un médico
    public function editarMedico($id)
    {
        $medico = User::findOrFail($id);
        return view('/opciones.medicos.editarMedico', compact('medico'));
    }

    // Actualiza un médico en la base de datos
    public function updateMedico(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Encuentra el médico y lo actualiza con los nuevos datos
        $medico = User::findOrFail($id);
        $medico->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $medico->password,
        ]);

        // Redirige a la vista de opciones de médicos con un mensaje de éxito
        return redirect()->route('medicos')->with('status', 'Médico actualizado correctamente');
    }

    // Elimina (desactiva) un médico en la base de datos
    public function eliminarMedico($id)
    {
        $medico = User::findOrFail($id);
        $medico->update(['activo' => 'no']);

        // Redirige a la vista de opciones de médicos con un mensaje de éxito
        return redirect()->route('medicos')->with('status', 'Médico eliminado correctamente');
    }

    // Muestra la lista de servicios activos
    public function mostrarServicios()
    {
        $servicios = Servicio::where('activo', 'si')->get();
        return view('/opciones.servicios.servicios', compact('servicios'));
    }

    // Guarda un nuevo servicio en la base de datos
    public function storeServicios(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Crea el servicio con los datos del formulario
        Servicio::create($request->all());

        // Redirige a la vista de opciones de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo servicio
    public function crearServicio()
    {
        return view('/opciones.servicios.agregarServicio');
    }

    // Muestra el formulario para editar un servicio
    public function editarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('/opciones.servicios.editarServicio', compact('servicio'));
    }

    // Actualiza un servicio en la base de datos
    public function updateServicio(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        // Encuentra el servicio y lo actualiza con los nuevos datos
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        // Redirige a la vista de opciones de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio actualizado correctamente');
    }

    // Elimina (desactiva) un servicio en la base de datos
    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        // Redirige a la vista de opciones de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }
}

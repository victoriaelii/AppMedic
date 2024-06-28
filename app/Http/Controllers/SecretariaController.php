<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    // Mostrar la vista principal de la secretaria
    public function index()
    {
        return view('/UsuarioSecretaria');
    }

    public function consultasForm()
    {
        // Lógica para manejar la vista del formulario de consultas
        return view('opciones.consultas.consultasform');
    }

    public function porConsultar()
    {
        $citas = Citas::with(['paciente', 'medico'])->paginate(10); // Ejemplo de cómo obtener citas con paginación y relaciones
        return view('opciones.consultas.porConsultar', compact('citas'));
    }

    public function showForm($id)
    {
        $cita = Citas::findOrFail($id);
        // Añade la lógica que necesites para mostrar el formulario de consulta
        return view('opciones.consultas.consultasform', compact('cita'));
    }

    // ********* PACIENTES
    // Guardar un nuevo paciente
    public function storePacientes(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes,correo',
            'telefono' => 'required|string|max:20',
        ]);

        Paciente::create($request->all());

        $redirect_to = $request->input('redirect_to', 'dashboardOpciones');
        return redirect()->route($redirect_to)->with('status', 'Paciente registrado correctamente');
    }

    // Mostrar todos los pacientes activos
    public function mostrarPacientes()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        return view('/opciones.dashboardOpciones', compact('pacientes'));
    }

    // Mostrar formulario para editar un paciente
    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('/opciones.pacientes.editarPaciente', compact('paciente'));
    }

    // Actualizar un paciente existente
    public function updatePaciente(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes,correo,' . $id,
            'telefono' => 'required|string|max:20',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('dashboardOpciones')->with('status', 'Paciente actualizado correctamente');
    }

    // Eliminar un paciente (desactivar)
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        return redirect()->route('dashboardOpciones')->with('status', 'Paciente eliminado correctamente');
    }

    // ********* PRODUCTOS
    // Mostrar todos los productos activos
    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('/opciones.productos.productos', compact('productos'));
    }

    // Guardar un nuevo producto
    public function storeProductos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Productos::create($request->all());

        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Mostrar formulario para agregar un producto
    public function crearProducto()
    {
        return view('/opciones.productos.agregarProducto');
    }

    // Mostrar formulario para editar un producto
    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('/opciones.productos.editarProducto', compact('producto'));
    }

    // Actualizar un producto existente
    public function updateProducto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Eliminar un producto (desactivar)
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

    // ********* CITAS
    public function tablaCitas(Request $request)
    {
        $query = Citas::with(['paciente', 'medico'])->where('activo', 'si');
    
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
    
        $citas = $query->paginate(10);
        return view('opciones.citas.tablaCitas', compact('citas'));
    }
    

    public function mostrarCitas()
    {
        $citas = Citas::select('citas.*', 'pacientes.nombres', 'pacientes.apepat', 'pacientes.apemat')
                        ->join('pacientes', 'citas.pacienteid', '=', 'pacientes.id')
                        ->where('citas.activo', 'si')
                        ->get();

        return view('/opciones.citas.citas', compact('citas'));
    }

    // Guardar una nueva cita
    public function storeCitas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->toDateString(),
            'hora' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:22:00',
            'pacienteid' => 'required|exists:pacientes,id',
            'medicoid' => 'required|exists:users,id',
        ]);
    
        // Verificar que el paciente no tenga más de una cita activa el mismo día
        $existingAppointment = Citas::where('fecha', $request->fecha)
            ->where('pacienteid', $request->pacienteid)
            ->where('activo', 'si')
            ->first();
    
        if ($existingAppointment) {
            return back()->withErrors(['fecha' => 'El paciente ya tiene una cita activa agendada para esta fecha.'])->withInput();
        }
    
        // Verificar que no haya citas duplicadas en la misma fecha y hora
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
    
        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }
    
    

    // Mostrar formulario para agregar una cita
    public function crearCita()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('opciones.citas.agregarCita', compact('pacientes', 'medicos'));
    }

    // Mostrar formulario para editar una cita
    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();
        return view('/opciones.citas.editarCita', compact('cita', 'pacientes', 'usuarios'));
    }

    // Actualizar una cita existente
    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->toDateString(),
            'hora' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:22:00',
            'pacienteid' => 'required|exists:pacientes,id'
        ]);
    
        // Verificar que el paciente no tenga más de una cita activa el mismo día
        $existingAppointment = Citas::where('fecha', $request->fecha)
            ->where('pacienteid', $request->pacienteid)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->first();
    
        if ($existingAppointment) {
            return back()->withErrors(['fecha' => 'El paciente ya tiene una cita activa agendada para esta fecha.'])->withInput();
        }
    
        // Verificar que no haya citas duplicadas en la misma fecha y hora
        $existingAppointmentSameHour = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('id', '!=', $id)
            ->where('activo', 'si')
            ->first();
    
        if ($existingAppointmentSameHour) {
            return back()->withErrors(['hora' => 'Ya existe una cita activa a esta hora.'])->withInput();
        }
    
        $cita = Citas::findOrFail($id);
        $cita->update($request->all());
    
        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }
    
    // Eliminar una cita (desactivar)
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->activo = 'no';
        $cita->save();
    
        return redirect()->route('tablaCitas')->with('status', 'Cita eliminada correctamente');
    }



    // calendar
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

    // ********* MEDICOS
    // Mostrar todos los médicos activos
    public function mostrarMedicos()
    {
        $medicos = User::whereIn('rol', ['medico', 'secretaria', 'colaborador'])
                        ->where('activo', 'si')
                        ->get();
        return view('/opciones.medicos.medicos', compact('medicos'));
    }

    // Guardar un nuevo médico
    public function storeMedicos(Request $request)
    {
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

        // Verificar si ya existe un médico registrado
        if ($request->rol === 'medico' && User::where('rol', 'medico')->exists()) {
            return redirect()->back()->withInput()->with('error', 'No se pueden registrar más de un doctor');
        }

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

        return redirect()->route('medicos')->with('status', 'Médico registrado correctamente');
    }

    // Mostrar formulario para agregar un médico
    public function crearMedico()
    {
        return view('/opciones.medicos.agregarMedico');
    }

    // Mostrar formulario para editar un médico
    public function editarMedico($id)
    {
        $medico = User::findOrFail($id);
        return view('/opciones.medicos.editarMedico', compact('medico'));
    }

    // Actualizar un médico existente
    public function updateMedico(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

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

        return redirect()->route('medicos')->with('status', 'Médico actualizado correctamente');
    }

    // Eliminar un médico (desactivar)
    public function eliminarMedico($id)
    {
        $medico = User::findOrFail($id);
        $medico->update(['activo' => 'no']);

        return redirect()->route('medicos')->with('status', 'Médico eliminado correctamente');
    }

    // ********* SERVICIOS
    // Mostrar todos los servicios activos
    public function mostrarServicios()
    {
        $servicios = Servicio::where('activo', 'si')->get();
        return view('/opciones.servicios.servicios', compact('servicios'));
    }

    // Guardar un nuevo servicio
    public function storeServicios(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Servicio::create($request->all());

        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    // Mostrar formulario para agregar un servicio
    public function crearServicio()
    {
        return view('/opciones.servicios.agregarServicio');
    }

    // Mostrar formulario para editar un servicio
    public function editarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('/opciones.servicios.editarServicio', compact('servicio'));
    }

    // Actualizar un servicio existente
    public function updateServicio(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios')->with('status', 'Servicio actualizado correctamente');
    }

    // Eliminar un servicio (desactivar)
    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }
}

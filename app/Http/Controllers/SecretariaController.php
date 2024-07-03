<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SecretariaController extends Controller
{
    public function index()
    {
        return view('/UsuarioSecretaria');
    }

    public function consultasForm()
    {
        return view('opciones.consultas.consultasform');
    }

    public function porConsultar()
    {
        $citas = Citas::with(['paciente', 'medico'])->paginate(10);
        return view('opciones.consultas.porConsultar', compact('citas'));
    }

    public function showForm($id)
    {
        $cita = Citas::findOrFail($id);
        return view('opciones.consultas.consultasform', compact('cita'));
    }

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

    public function mostrarPacientes()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        return view('/opciones.dashboardOpciones', compact('pacientes'));
    }

    public function editarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('/opciones.pacientes.editarPaciente', compact('paciente'));
    }

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

    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        return redirect()->route('dashboardOpciones')->with('status', 'Paciente eliminado correctamente');
    }

    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('/opciones.productos.productos', compact('productos'));
    }

    public function storeProductos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Productos::create($request->all());

        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    public function crearProducto()
    {
        return view('/opciones.productos.agregarProducto');
    }

    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('/opciones.productos.editarProducto', compact('producto'));
    }

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

    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

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

    public function storeCitas(Request $request)
    {
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
    
    public function crearCita()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('opciones.citas.agregarCita', compact('pacientes', 'medicos'));
    }

    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Paciente::where('activo', 'si')->get();
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        return view('/opciones.citas.editarCita', compact('cita', 'pacientes', 'medicos'));
    }
    
    public function updateCita(Request $request, $id)
    {
        // Convertir la hora de formato 12 horas a 24 horas
        $hora = date('H:i', strtotime($request->hora));
        $fecha = $request->input('fecha');
    
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->toDateString(),
            'hora' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:22:00',
            'pacienteid' => 'required|exists:pacientes,id',
            'medicoid' => 'required|exists:users,id',
        ]);
    
        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora, 'America/Mexico_City');
        $ahora = Carbon::now('America/Mexico_City');
    
        if ($fechaHoraCita->isPast()) {
            return back()->withErrors(['hora' => 'Hora pasada. Elige una hora futura.'])->withInput();
        }
    
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
    
    
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->activo = 'no';
        $cita->save();
    
        return redirect()->route('tablaCitas')->with('status', 'Cita eliminada correctamente');
    }

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

    public function mostrarMedicos()
    {
        $medicos = User::whereIn('rol', ['medico', 'secretaria', 'colaborador'])
                        ->where('activo', 'si')
                        ->get();
        return view('/opciones.medicos.medicos', compact('medicos'));
    }

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

    public function crearMedico()
    {
        return view('/opciones.medicos.agregarMedico');
    }

    public function editarMedico($id)
    {
        $medico = User::findOrFail($id);
        return view('/opciones.medicos.editarMedico', compact('medico'));
    }

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

    public function eliminarMedico($id)
    {
        $medico = User::findOrFail($id);
        $medico->update(['activo' => 'no']);

        return redirect()->route('medicos')->with('status', 'Médico eliminado correctamente');
    }

    public function mostrarServicios()
    {
        $servicios = Servicio::where('activo', 'si')->get();
        return view('/opciones.servicios.servicios', compact('servicios'));
    }

    public function storeServicios(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Servicio::create($request->all());

        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    public function crearServicio()
    {
        return view('/opciones.servicios.agregarServicio');
    }

    public function editarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('/opciones.servicios.editarServicio', compact('servicio'));
    }

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

    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }
}

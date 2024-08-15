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
use Illuminate\Support\Facades\DB;


use PDF; 

// Controlador que maneja las funciones de la secretaria
class SecretariaController extends Controller
{
    // Muestra la vista principal del usuario secretaria
    public function index()
    {
        return view('/UsuarioSecretaria');
    }
    public function mostrarHistorialMedico($id)
    {
        $paciente = Paciente::with(['citas.consulta.servicios', 'citas.consulta.productos'])->findOrFail($id);
        return view('opciones.pacientes.historial_medico', compact('paciente'));
    }


//////// REPORTES

    public function mostrarReportes()
    {
        $hoy = Carbon::now()->toDateString();

        // Obtener productos vendidos con la fecha de creación
        $ventasDelDia = DB::table('consulta_producto')
                            ->join('productos', 'consulta_producto.producto_id', '=', 'productos.id')
                            ->whereDate('consulta_producto.created_at', $hoy)
                            ->select('productos.nombre', 'productos.precio', 'consulta_producto.cantidad', 'consulta_producto.created_at as fecha_vencimiento', DB::raw('productos.precio * consulta_producto.cantidad as total'))
                            ->get();

        $totalVentasProductos = $ventasDelDia->sum('total');

        // Obtener servicios vendidos con la fecha de creación
        $serviciosDelDia = DB::table('consulta_servicio')
                            ->join('servicios', 'consulta_servicio.servicio_id', '=', 'servicios.id')
                            ->whereDate('consulta_servicio.created_at', $hoy)
                            ->select('servicios.nombre', 'servicios.precio', 'consulta_servicio.created_at as fecha_vencimiento', DB::raw('servicios.precio as total'))
                            ->get();

        $totalVentasServicios = $serviciosDelDia->sum('total');

        // Total general
        $totalVentas = $totalVentasProductos + $totalVentasServicios;

        return view('opciones.Reportes.VistaReportes', compact('ventasDelDia', 'totalVentasProductos', 'serviciosDelDia', 'totalVentasServicios', 'totalVentas'));
    }

    public function generarReporte(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'mes' => 'required',
            'anio' => 'required|numeric',
        ]);
    
        $mes = $request->input('mes');
        $anio = $request->input('anio');
    
        // Obtener productos vendidos en el mes seleccionado con la fecha de creación
        $ventasDelMes = DB::table('consulta_producto')
                            ->join('productos', 'consulta_producto.producto_id', '=', 'productos.id')
                            ->whereMonth('consulta_producto.created_at', $mes)
                            ->whereYear('consulta_producto.created_at', $anio)
                            ->select('productos.nombre', 'productos.precio', 'consulta_producto.cantidad', 'consulta_producto.created_at as fecha_vencimiento', DB::raw('productos.precio * consulta_producto.cantidad as total'))
                            ->get();
    
        $totalVentasProductosMes = $ventasDelMes->sum('total');
    
        // Obtener servicios vendidos en el mes seleccionado con la fecha de creación
        $serviciosDelMes = DB::table('consulta_servicio')
                            ->join('servicios', 'consulta_servicio.servicio_id', '=', 'servicios.id')
                            ->whereMonth('consulta_servicio.created_at', $mes)
                            ->whereYear('consulta_servicio.created_at', $anio)
                            ->select('servicios.nombre', 'servicios.precio', 'consulta_servicio.created_at as fecha_vencimiento', DB::raw('servicios.precio as total'))
                            ->get();
    
        $totalVentasServiciosMes = $serviciosDelMes->sum('total');
    
        // Total general del mes
        $totalVentasMes = $totalVentasProductosMes + $totalVentasServiciosMes;
    
        // Redirigir a la vista con los datos del reporte
        return view('opciones.Reportes.VistaReportes', [
            'ventasDelDia' => $ventasDelMes,
            'totalVentasProductos' => $totalVentasProductosMes,
            'serviciosDelDia' => $serviciosDelMes,
            'totalVentasServicios' => $totalVentasServiciosMes,
            'totalVentas' => $totalVentasMes,
        ])->with('success', 'Reporte mensual generado correctamente.');
    }
    
    

    /// PDF REPORTES

    public function descargarReporteDelDiaPdf()
    {
        $hoy = Carbon::now()->toDateString();

        // Obtener productos vendidos
        $ventasDelDia = DB::table('consulta_producto')
            ->join('productos', 'consulta_producto.producto_id', '=', 'productos.id')
            ->whereDate('consulta_producto.created_at', $hoy)
            ->select('productos.nombre', 'productos.precio', 'consulta_producto.cantidad', DB::raw('productos.precio * consulta_producto.cantidad as total'))
            ->get();

        $totalVentasProductos = $ventasDelDia->sum('total');

        // Obtener servicios vendidos
        $serviciosDelDia = DB::table('consulta_servicio')
            ->join('servicios', 'consulta_servicio.servicio_id', '=', 'servicios.id')
            ->whereDate('consulta_servicio.created_at', $hoy)
            ->select('servicios.nombre', 'servicios.precio', DB::raw('servicios.precio as total'))
            ->get();

        $totalVentasServicios = $serviciosDelDia->sum('total');

        // Total general
        $totalVentas = $totalVentasProductos + $totalVentasServicios;

        $pdf = PDF::loadView('opciones.Reportes.ReporteDelDiaPdf', compact('ventasDelDia', 'totalVentasProductos', 'serviciosDelDia', 'totalVentasServicios', 'totalVentas'));

        return $pdf->download('reporte_ventas_del_dia.pdf');
    }

    public function descargarReporteMensualPdf(Request $request)
    {
        $mes = $request->input('mes');
        $anio = $request->input('anio');

        // Obtener productos vendidos en el mes seleccionado
        $ventasDelMes = DB::table('consulta_producto')
            ->join('productos', 'consulta_producto.producto_id', '=', 'productos.id')
            ->whereMonth('consulta_producto.created_at', $mes)
            ->whereYear('consulta_producto.created_at', $anio)
            ->select('productos.nombre', 'productos.precio', 'consulta_producto.cantidad', 'consulta_producto.created_at', DB::raw('productos.precio * consulta_producto.cantidad as total'))
            ->get();

        $totalVentasProductosMes = $ventasDelMes->sum('total');

        // Obtener servicios vendidos en el mes seleccionado
        $serviciosDelMes = DB::table('consulta_servicio')
            ->join('servicios', 'consulta_servicio.servicio_id', '=', 'servicios.id')
            ->whereMonth('consulta_servicio.created_at', $mes)
            ->whereYear('consulta_servicio.created_at', $anio)
            ->select('servicios.nombre', 'servicios.precio', 'consulta_servicio.created_at', DB::raw('servicios.precio as total'))
            ->get();

        $totalVentasServiciosMes = $serviciosDelMes->sum('total');

        // Total general del mes
        $totalVentasMes = $totalVentasProductosMes + $totalVentasServiciosMes;

        $pdf = PDF::loadView('opciones.Reportes.ReporteMensualPdf', compact('ventasDelMes', 'totalVentasProductosMes', 'serviciosDelMes', 'totalVentasServiciosMes', 'totalVentasMes'));

        return $pdf->download('reporte_ventas_mensual.pdf');
    }
    //////////////////////////

    
    
    public function buscarPaciente(Request $request)
    {
        $query = $request->input('q');
        $pacientes = Paciente::where('activo', 'si') // Filtrar solo pacientes activos
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('nombres', 'like', "%{$query}%")
                             ->orWhere('apepat', 'like', "%{$query}%")
                             ->orWhere('apemat', 'like', "%{$query}%")
                             ->orWhere('correo', 'like', "%{$query}%");
            })
            ->get(['id', 'nombres', 'apepat', 'apemat', 'correo']);
        
        return response()->json($pacientes);
    }
    
    
    public function descargarHistorialMedicoPdf($id)
    {
        $paciente = Paciente::with('citas.consulta.servicios', 'citas.consulta.productos')->findOrFail($id);

        $pdf = PDF::loadView('opciones.pacientes.historial_medico_pdf', compact('paciente'));
        return $pdf->download('historial_medico_' . $paciente->nombres . '.pdf');
    }
    
    // Muestra el formulario de consultas
    public function consultasForm()
    {
        return view('opciones.consultas.consultasform');
    }

    public function porConsultar(Request $request)
    {
        $query = Citas::with(['paciente', 'medico', 'consulta.servicios', 'consulta.productos', 'consulta.enfermera'])
                    ->whereHas('paciente', function ($q) {
                        $q->where('activo', 'si'); // Filtrar solo pacientes activos
                    })
                    ->where(function($query) {
                        $query->where('activo', 'si')
                                ->orWhereHas('consulta', function($q) {
                                    
                                });
                    });
    
        // Filtrar por nombre, apellidos o correo del paciente
        if ($request->filled('nombre')) {
            $nombreCompleto = $request->input('nombre');
            $nombrePartes = explode(' ', $nombreCompleto);
    
            $query->whereHas('paciente', function($q) use ($nombrePartes) {
                foreach ($nombrePartes as $parte) {
                    $q->where(function($query) use ($parte) {
                        $query->where('nombres', 'like', '%' . $parte . '%')
                            ->orWhere('apepat', 'like', '%' . $parte . '%')
                            ->orWhere('apemat', 'like', '%' . $parte . '%');
                    });
                }
            });
        }
    
        // Filtrar por estado de la consulta
        if ($request->filled('estado')) {
            $query->whereHas('consulta', function($q) use ($request) {
                $q->where('estado', $request->input('estado'));
            });
        }
    
        // Filtrar por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->input('fecha'));
        }
    
        // Filtrar por rol del usuario
        if (auth()->user()->rol == 'admin') {
            $query->whereHas('consulta', function($q) {
                $q->where('estado', 'finalizada');
            });
        }
    
        $citas = $query->paginate(10);
    
        return view('opciones.consultas.porConsultar', compact('citas'));
    }
    
    
    

    public function eliminarConsulta($id)
    {
        $consulta = Consultas::findOrFail($id);
        $consulta->estado = 'eliminada';
        $consulta->save();

        return redirect()->route('consultas.porConsultar')->with('status', 'Consulta eliminada correctamente');
    }

    
    // Muestra el formulario para una consulta específica
    public function showForm($id)
    {
        $cita = Citas::findOrFail($id);
        $servicios = Servicio::where('activo', 'si')->get();
        $productos = Productos::where('activo', 'si')->get();
        $enfermeras = User::where('rol', 'enfermera')->get(); // enfermeras ACTIVAS
        return view('opciones.consultas.consultasform', compact('cita', 'servicios', 'productos', 'enfermeras'));
    }

    // crear CONSULTA
    public function storeConsultas(Request $request)
    {
        try {
            // Valida los datos del formulario
            $request->validate([
                'cita_id' => 'required|exists:citas,id',
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
                'enfermera_id' => 'nullable|exists:users,id',
            ]);
    
            // Verifica si la cita ya tiene una consulta asociada
            $cita = Citas::findOrFail($request->cita_id);
            if ($cita->consulta) {
                return response()->json(['status' => false, 'error' => 'Esta cita ya tiene una consulta asociada.'], 400);
            }
    
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
                'totalPagar' => 100, 
                'usuariomedicoid' => auth()->user()->id,
                'enfermera_id' => $request->enfermera_id, 
            ]);
    
            $totalPagar = 100; // Precio base de la consulta
            $detalleCostos = [];
    
            // Si hay servicios seleccionados, se agregan a la consulta y se suman al total
            if ($request->has('servicios')) {
                $servicios = Servicio::whereIn('id', $request->servicios)->get();
                foreach ($servicios as $servicio) {
                    $consulta->servicios()->attach($servicio->id, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $totalPagar += $servicio->precio;
                    $detalleCostos[] = ['nombre' => $servicio->nombre, 'precio' => $servicio->precio, 'cantidad' => 1, 'tipo' => 'servicio'];
                }
            }
    
            // Si hay productos seleccionados, se agregan a la consulta y se suman al total
            if ($request->has('productos')) {
                foreach ($request->productos as $productoData) {
                    if (isset($productoData['id']) && isset($productoData['cantidad']) && $productoData['cantidad'] > 0) {
                        $producto = Productos::findOrFail($productoData['id']);
                        $cantidad = $productoData['cantidad'];
                        $consulta->productos()->attach($producto->id, [
                            'cantidad' => $cantidad,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $totalPagar += $producto->precio * $cantidad;
                        $detalleCostos[] = ['nombre' => $producto->nombre, 'precio' => $producto->precio * $cantidad, 'cantidad' => $cantidad, 'tipo' => 'producto'];
    
                        // Restar la cantidad seleccionada del producto
                        $producto->cantidad -= $cantidad;
                        if ($producto->cantidad < 5) {
                            $producto->abastecer = true;
                            // abastecer
                            session()->flash('alert', 'El producto ' . $producto->nombre . ' necesita ser abastecido.');
                        }
                        $producto->save();
                    }
                }
            }
    
            // Actualiza el total a pagar en la consulta
            $consulta->update(['totalPagar' => $totalPagar]);
    
            return response()->json(['status' => true, 'detalleCostos' => $detalleCostos, 'totalPagar' => $totalPagar]);
        } catch (\Exception $e) {
            \Log::error('Error al guardar la consulta: ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    
    

    public function editConsultas($id)
    {
        $consulta = Consultas::findOrFail($id);
        $receteItems = $this->parseReceta($consulta->recete);
        $signosVitales = $this->parseSignosVitales($consulta->signos_vitales);
        $servicios = Servicio::where('activo', 'si')->get();
        $productos = Productos::where('activo', 'si')->get();
        $enfermeras = User::where('rol', 'enfermera')->get();
        return view('opciones.consultas.editConsulta', compact('consulta', 'receteItems', 'signosVitales', 'servicios', 'productos', 'enfermeras'));
    }
    

    private function parseReceta($recete)
    {
        // si esta vacio se manda el array vacio
        if (empty($recete)) {
            return [];
        }
    
        $items = explode(' | ', $recete);
        $parsedItems = [];
    
        foreach ($items as $item) {
             // Si la parte no contiene notas de RECETA, se toma commoun ítem de medicación.
            if (strpos($item, 'Notas:') === false) {
                $itemParts = explode(', ', $item);
                // rray asosiativo para guardar los detalles de receta
                $parsedItems[] = [
                    'medicacion' => isset($itemParts[0]) ? str_replace('Medicación: ', '', $itemParts[0]) : '',
                    'cantidad' => isset($itemParts[1]) ? str_replace('Cantidad: ', '', $itemParts[1]) : '',
                    'frecuencia' => isset($itemParts[2]) ? str_replace('Frecuencia: ', '', $itemParts[2]) : '',
                    'duracion' => isset($itemParts[3]) ? str_replace('Duración: ', '', $itemParts[3]) : '',
                ];
            } else {
                // si tinee notas se guarda cmo adicional en la recera MISMO CAMPO
                $parsedItems['notas'] = str_replace('Notas: ', '', $item);
            }
        }
    // SE MAND EL ARRAY
        return $parsedItems;
    }
    

    private function parseSignosVitales($signosVitales)
    {
        if (empty($signosVitales)) {
            return [];
        }
    
        // Decodifica caracteres especiales
        $signosVitales = html_entity_decode($signosVitales, ENT_QUOTES, 'UTF-8');
    
        $signosArray = explode(', ', $signosVitales);
        $parsedSignos = [];
    
        foreach ($signosArray as $signo) {
            $signoParts = explode(': ', $signo);
            if (count($signoParts) == 2) {
                // Extracción del valor numérico
                $key = strtolower(str_replace([' ', 'ó', 'á'], ['_', 'o', 'a'], $signoParts[0]));
                $value = preg_replace('/[^0-9.]/', '', trim($signoParts[1]));
                $parsedSignos[$key] = $value;
            }
        }
    
        return $parsedSignos;
    }
    
    
    
    
    public function updateConsultas(Request $request, $id)
    {
        try {
            // Busca la consulta existente
            $consulta = Consultas::findOrFail($id);
    
            // Construir el nuevo campo de 'recete' con los datos enviados en la solicitud
            $receteItems = [];
            if ($request->has('medicacion')) {
                foreach ($request->input('medicacion') as $index => $medicacion) {
                    $cantidad = $request->input('cantidad')[$index];
                    $frecuencia = $request->input('frecuencia')[$index];
                    $duracion = $request->input('duracion')[$index];
                    $receteItems[] = "Medicación: $medicacion, Cantidad: $cantidad, Frecuencia: $frecuencia, Duración: $duracion";
                }
            }
    
            // Agregar notas si están presentes
            if ($request->has('notas_receta')) {
                $receteItems[] = "Notas: " . $request->input('notas_receta');
            }
    
            // Convertir el array de recete en un string separado por ' | '
            $recete = implode(' | ', $receteItems);
    
            // Guardar signos vitales en el formato correcto
            $signosVitales = [
                'Talla' => $request->input('talla'),
                'Temperatura' => $request->input('temperatura'),
                'Saturacion' => $request->input('saturacion'),
                'Frecuencia cardiaca' => $request->input('frecuencia_cardiaca'),
                'Peso' => $request->input('peso'),
                'Tension arterial' => $request->input('tension_arterial'),
            ];
    
            // Convertir los signos vitales a una cadena de texto
            $signosVitalesString = collect($signosVitales)
                ->map(function ($value, $key) {
                    return "{$key}: {$value}";
                })
                ->implode(', ');
    
            // Actualizar los campos de la consulta
            $consulta->update([
                'diagnostico' => $request->input('diagnostico', $consulta->diagnostico),
                'recete' => $recete,
                'signos_vitales' => $signosVitalesString,
                'motivo_consulta' => $request->input('motivo_consulta', $consulta->motivo_consulta),
                'notas_padecimiento' => $request->input('notas_padecimiento', $consulta->notas_padecimiento),
                'examen_fisico' => $request->input('examen_fisico', $consulta->examen_fisico),
                'pronostico' => $request->input('pronostico', $consulta->pronostico),
                'plan' => $request->input('plan', $consulta->plan),
                'alergias' => $request->input('alergias', $consulta->alergias),
                'enfermera_id' => $request->input('enfermera_id', $consulta->enfermera_id),
            ]);
    
            // Calcular el costo total y actualizar los servicios y productos
            $totalPagar = 100; // Precio base
            $detalleCostos = [];
    
            if ($request->has('servicios')) {
                $consulta->servicios()->sync($request->input('servicios', []));
                $servicios = Servicio::whereIn('id', $request->input('servicios', []))->get();
                foreach ($servicios as $servicio) {
                    $totalPagar += $servicio->precio;
                    $detalleCostos[] = ['nombre' => $servicio->nombre, 'precio' => $servicio->precio];
                }
            } else {
                $consulta->servicios()->sync([]);
            }
    
            if ($request->has('productos')) {
                $productosSync = [];
                foreach ($request->input('productos', []) as $productoData) {
                    if (isset($productoData['id']) && isset($productoData['cantidad']) && $productoData['cantidad'] > 0) {
                        $producto = Productos::findOrFail($productoData['id']);
                        $cantidad = $productoData['cantidad'];
                        $productosSync[$producto->id] = ['cantidad' => $cantidad];
                        $totalPagar += $producto->precio * $cantidad;
                        $detalleCostos[] = ['nombre' => $producto->nombre, 'precio' => $producto->precio * $cantidad, 'cantidad' => $cantidad];
    
                        // Actualizar la cantidad del producto
                        $producto->cantidad -= $cantidad;
                        $producto->save();
                    }
                }
                $consulta->productos()->sync($productosSync);
            } else {
                $consulta->productos()->sync([]);
            }
    
            // Actualizar el total a pagar en la consulta
            $consulta->update(['totalPagar' => $totalPagar]);
    
            // Respuesta de éxito
            return response()->json(['status' => true, 'detalleCostos' => $detalleCostos, 'totalPagar' => $totalPagar]);
        } catch (\Exception $e) {
            // Registrar el error para depuración
            \Log::error('Error en updateConsultas: ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    
    
    // terminar la consulta 
    public function terminarConsulta($id)
    {
        $consulta = Consultas::findOrFail($id);
        $consulta->update(['estado' => 'finalizada']);

        return redirect()->route('consultas.porConsultar')->with('status', 'Consulta finalizada correctamente');
    }


    // Método para generar código aleatorio
    public function generarCodigo($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->codigo = $this->generarCodigoAleatorio();
        $paciente->save();

        return redirect()->back()->with('success', 'Código generado exitosamente');
    }

    // Método privado para generar código aleatorio
    private function generarCodigoAleatorio()
    {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
    }

    // Método para verificar el código y mostrar el historial médico
    public function verificarCodigo(Request $request)
    {
        // Validar el código manualmente
        if (strlen($request->codigo) !== 8) {
            return response()->json(['message' => 'Código Incorrecto.'], 400);
        }
    
        $paciente = Paciente::where('codigo', $request->codigo)->first();
    
        if ($paciente) {
            if ($paciente->activo == 'no') {
                return response()->json(['message' => 'El historial del paciente está inactivo.'], 400);
            }
    
            if ($paciente->citas->contains(fn($cita) => $cita->consulta && $cita->consulta->estado == 'finalizada')) {
                // Redirige a la ruta del historial médico con el ID del paciente
                return response()->json(['redirect_url' => route('historialMedico.show', ['id' => $paciente->id])]);
            }
        }
    
        return response()->json(['message' => 'Código Incorrecto o sin citas finalizadas.'], 400);
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

        // Redirige a la vista de opciones de pacientes
        $redirect_to = $request->input('redirect_to', 'dashboardOpciones');
        return redirect()->route($redirect_to)->with('status', 'Paciente registrado correctamente');
    }

    public function mostrarPacientes(Request $request)
    {
        $query = Paciente::query();
    
        if ($request->filled('nombre')) {
            $nombreCompleto = $request->input('nombre');
            $nombrePartes = explode(' ', $nombreCompleto);
    
            $query->where(function ($query) use ($nombrePartes) {
                foreach ($nombrePartes as $parte) {
                    $query->where(function ($query) use ($parte) {
                        $query->where('nombres', 'like', '%' . $parte . '%')
                              ->orWhere('apepat', 'like', '%' . $parte . '%')
                              ->orWhere('apemat', 'like', '%' . $parte . '%');
                    });
                }
            });
        }
    
        if ($request->filled('fechanac')) {
            $query->whereDate('fechanac', $request->input('fechanac'));
        }
    
        if ($request->filled('correo')) {
            $correo = $request->input('correo');
            $query->where('correo', 'like', "%{$correo}%");
        }
    
        $pacientes = $query->where('activo', 'si')->get();
        $totalPacientesActivos = $pacientes->count();
    
        return view('/opciones.dashboardOpciones', compact('pacientes', 'totalPacientesActivos'));
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

    // Elimina (desactiva (0)) un paciente en la base de datos
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => 'no']);

        // Redirige a la vista de opciones de pacientes con un mensaje de éxito
        return redirect()->route('dashboardOpciones')->with('status', 'Paciente eliminado correctamente');
    }

    // Muestra la lista de productos activos
    public function mostrarProductos(Request $request)
    {
        $query = Productos::query();
    
        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }
    
        // Filtro por precio
        if ($request->filled('precio')) {
            $query->where('precio', $request->input('precio'));
        }
    
        $productos = $query->where('activo', 'si')->get();
    
        return view('opciones.productos.productos', compact('productos'));
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

        // Redirige a la vista de opciones de productos
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

        // Encuentra el producto y lo actualiza 
        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        // Redirige a la vista de opciones de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Elimina (desactiva) un producto en la BD
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        // Redirige a la vista de opciones de productos
        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

    // Método para desactivar citas que tienen consulta asociada
    private function desactivarCitasConConsulta()
    {
        // Obtener todas las citas que tienen una consulta asociada
        $citasConConsulta = Citas::has('consulta')->where('activo', 'si')->get();

        // Iterar sobre cada cita y actualizar el campo activo a 'no'
        foreach ($citasConConsulta as $cita) {
            $cita->activo = 'no';
            $cita->save();
        }
    }

    // Muestra la tabla de citas
    public function tablaCitas(Request $request)
    {
        // Desactivar citas que tienen consulta asociada
        $this->desactivarCitasConConsulta();
    
        $now = Carbon::now('America/Monterrey');
    
        $query = Citas::with(['paciente', 'medico'])
                    ->where('activo', 'si') // Solo citas activas
                    ->whereHas('paciente', function ($query) {
                        $query->where('activo', 'si'); // Solo pacientes activos
                    })
                    ->where(function ($query) use ($now) {
                        $query->where('fecha', '>', $now->toDateString())
                              ->orWhere(function ($query) use ($now) {
                                  $query->where('fecha', '=', $now->toDateString())
                                        ->where('hora', '>', $now->toTimeString());
                              });
                    });
    
        // Aplicar filtros adicionales si se especifican en la búsqueda
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
    
        // Contar el total de citas activas
        $totalCitasActivas = $query->count();
    
        // Obtener las citas ordenadas por fecha y hora, paginadas
        $citas = $query->orderBy('fecha')->orderBy('hora')->paginate(10);
    
        return view('opciones.citas.tablaCitas', compact('citas', 'totalCitasActivas'));
    }
    
    
    
    // Desactiva las citas pasadas
    public function desactivarCitasPasadas()
    {
        $now = Carbon::now('America/Monterrey');
    
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
        $now = Carbon::now('America/Monterrey');
        
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
        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora, 'America/Monterrey');
        $ahora = Carbon::now('America/Monterrey');

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
        return redirect()->route($redirect_to)->with('status', 'Cita registrada correctamente')->with('success', true);
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
        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $request->fecha . ' ' . $hora, 'America/Monterrey');
        $ahora = Carbon::now('America/Monterrey');
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
    
        if (request()->ajax()) {
            return response()->json(['status' => 'Cita eliminada correctamente']);
        }
    
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

    //MMOSTRAR LOS USUARIOS EN LA VISTA ADMIN
    public function mostrarMedicos(Request $request)
    {
        $query = User::query();
        
        // Filtrar por nombre, apellido paterno o apellido materno
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where(function ($query) use ($nombre) {
                // Dividimos el nombre por espacios y filtramos cada parte por separado
                $searchTerms = explode(' ', $nombre);
                foreach ($searchTerms as $term) {
                    $query->where('nombres', 'like', "%{$term}%")
                          ->orWhere('apepat', 'like', "%{$term}%")
                          ->orWhere('apemat', 'like', "%{$term}%");
                }
            });
        }
        
        // Filtrar por correo
        if ($request->filled('correo')) {
            $correo = $request->input('correo');
            $query->where('email', 'like', "%{$correo}%");
        }
        
        // Filtrar por rol
        if ($request->filled('rol')) {
            $rol = $request->input('rol');
            $query->where('rol', $rol);
        }
        
        // Obtener los médicos, secretarias o enfermeras activas según los filtros aplicados
        $medicos = $query->whereIn('rol', ['medico', 'secretaria', 'enfermera'])
                        ->where('activo', 'si')
                        ->get();
    
        // Contar el total de usuarios activos
        $totalUsuariosActivos = $medicos->count();
        
        // Devolver la vista con los datos filtrados
        return view('/opciones.medicos.medicos', compact('medicos', 'totalUsuariosActivos'));
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
            'rol' => ['required', 'in:medico,secretaria,enfermera,admin'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->rol === 'medico' && User::where('rol', 'medico')->exists()) {
            return redirect()->back()->withInput()->with('error', 'Solo se acepta un único médico en el sistema');
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
    public function mostrarServicios(Request $request)
    {
        $request->validate([
            'precio' => 'nullable|numeric|min:0',
        ]);
        
        $query = Servicio::query();
    
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'like', "%{$nombre}%");
        }

        if ($request->filled('precio')) {
            $query->where('precio', $request->precio);
        }
    
        $servicios = $query->where('activo', 'si')->get();
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

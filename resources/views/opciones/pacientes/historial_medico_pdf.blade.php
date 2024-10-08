<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial Médico</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        .historial-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .historial-item h2 {
            margin-top: 0;
            color: #495057;
        }
        .historial-item p {
            margin: 5px 0;
            line-height: 1.5;
            word-wrap: break-word;
            word-break: break-all;
        }
        .footer {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #124A87;
            color: #ffffff;
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <h1>Historial Médico de {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</h1>
    @foreach($paciente->citas as $cita)
        @if($cita->consulta && $cita->consulta->estado == 'finalizada')
            <div class="historial-item">
                <h2>Fecha: {{ $cita->fecha }}</h2>
                <p><strong>Médico:</strong> {{ optional($cita->consulta->medico)->nombres }} {{ optional($cita->consulta->medico)->apepat }} {{ optional($cita->consulta->medico)->apemat }}</p>
                @if($cita->consulta->enfermera)
                    <p><strong>Enfermera:</strong> {{ $cita->consulta->enfermera->nombres }} {{ $cita->consulta->enfermera->apepat }}</p>
                @endif
                <p><strong>Diagnóstico:</strong> {{ $cita->consulta->diagnostico }}</p>
                <p><strong>Receta:</strong> {{ $cita->consulta->recete }}</p>
                <p><strong>Signos Vitales:</strong> {{ $cita->consulta->signos_vitales }}</p>
                <p><strong>Motivo de Consulta:</strong> {{ $cita->consulta->motivo_consulta }}</p>
                <p><strong>Notas del Padecimiento:</strong> {{ $cita->consulta->notas_padecimiento }}</p>
                <p><strong>Examen Físico:</strong> {{ $cita->consulta->examen_fisico }}</p>
                <p><strong>Pronóstico:</strong> {{ $cita->consulta->pronostico }}</p>
                <p><strong>Plan de Tratamiento:</strong> {{ $cita->consulta->plan }}</p>
                <p><strong>Alergias:</strong> {{ $cita->consulta->alergias }}</p>
                <p><strong>Servicios:</strong></p>
                @foreach($cita->consulta->servicios as $servicio)
                    <p>{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}</p>
                @endforeach
                <p><strong>Productos:</strong></p>
                @foreach($cita->consulta->productos as $producto)
                    <p>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }}) - ${{ number_format($producto->precio, 2) }} c/u, Total: ${{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</p>
                @endforeach
                <p><strong>Total a Pagar:</strong> ${{ number_format($cita->consulta->totalPagar, 2) }}</p>
            </div>
        @endif
    @endforeach
    <div class="footer">
        <p>Historial Médico generado el {{ date('d/m/Y') }}</p>
    </div>
</body>
</html>

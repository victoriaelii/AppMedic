<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial Médico</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Historial Médico de {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Receta</th>
                <th>Servicios</th>
                <th>Productos</th>
                <th>Total a Pagar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paciente->citas as $cita)
                @if($cita->consulta && $cita->consulta->estado == 'finalizada')
                    <tr>
                        <td>{{ $cita->fecha }}</td>
                        <td>{{ $cita->consulta->diagnostico }}</td>
                        <td>{{ $cita->consulta->recete }}</td>
                        <td>
                            @foreach($cita->consulta->servicios as $servicio)
                                <p>{{ $servicio->nombre }}</p>
                            @endforeach
                        </td>
                        <td>
                            @foreach($cita->consulta->productos as $producto)
                                <p>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }})</p>
                            @endforeach
                        </td>
                        <td>${{ number_format($cita->consulta->totalPagar, 2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>

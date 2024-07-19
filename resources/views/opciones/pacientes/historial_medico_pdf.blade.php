<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial Médico</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
            color: #495057;
        }
        td p {
            margin: 0;
            padding: 0;
        }
        .footer {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #124A87;
            color: #ffffff;
            position: absolute;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="container">
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
    </div>
    <div class="footer">
        <p>Historial Médico generado el {{ date('d/m/Y') }}</p>
    </div>
</body>
</html>

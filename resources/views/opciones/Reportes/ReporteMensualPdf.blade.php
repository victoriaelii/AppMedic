<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas del Mes - {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM YYYY') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Reporte de Ventas del Mes - {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM YYYY') }}</h2>

    <h3>Productos Vendidos:</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha de Venta</th> 
            </tr>
        </thead>
        <tbody>
            @forelse($ventasDelMes as $venta)
                <tr>
                    <td>{{ $venta->nombre }}</td>
                    <td>${{ number_format($venta->precio, 2) }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') }}</td> <!-- FECHA DE created_at -->
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No hay ventas registradas en este mes.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Total Productos:</td>
                <td>${{ number_format($totalVentasProductosMes, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <h3>Servicios Vendidos:</h3>
    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Fecha de Venta</th> 
            </tr>
        </thead>
        <tbody>
            @forelse($serviciosDelMes as $servicio)
                <tr>
                    <td>{{ $servicio->nombre }}</td>
                    <td>${{ number_format($servicio->precio, 2) }}</td>
                    <td>${{ number_format($servicio->total, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($servicio->created_at)->format('d/m/Y') }}</td> <!-- FECHA DE CREATED AT-->
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No hay servicios vendidos en este mes.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Servicios:</td>
                <td>${{ number_format($totalVentasServiciosMes, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <h3 style="text-align: right;">Total Vendido: ${{ number_format($totalVentasMes, 2) }}</h3>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pedidos</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #e11d48; padding-bottom: 10px; }
        .header h1 { color: #e11d48; margin: 0; font-size: 24px; }
        .header p { color: #666; margin: 5px 0 0 0; }
        table { w-full; border-collapse: collapse; margin-top: 20px; width: 100%; }
        th { background-color: #fce7f3; color: #9f1239; padding: 10px; text-align: left; border: 1px solid #fbcfe8; }
        td { padding: 8px 10px; border: 1px solid #e5e7eb; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte General de Pedidos</h1>
        <p>Sistema Logístico Coca-Cola - Fecha: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Destino</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>#{{ $pedido->id }}</td>
                <td>{{ $pedido->cliente_nombre }}</td>
                <td>{{ $pedido->destino }}</td>
                <td>${{ number_format($pedido->total, 2) }}</td>
                <td>{{ $pedido->estado }}</td>
                <td>{{ $pedido->fecha_pedido }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

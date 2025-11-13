<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #667eea;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
            text-align: right;
            margin-top: 20px;
        }
        .header-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header-info">
        <h1>Relatório de Pedidos</h1>
        <p><strong>Data de Geração:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total de Pedidos:</strong> {{ $pedidos->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data Pedido</th>
                <th>Data Entrega</th>
                <th>Forma Pagamento</th>
                <th>Status</th>
                <th>Total (R$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>#{{ $pedido->id }}</td>
                    <td>{{ $pedido->usuario->nome }}</td>
                    <td>{{ $pedido->dataPedido->format('d/m/Y H:i') }}</td>
                    <td>{{ $pedido->dataEntrega ? $pedido->dataEntrega->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ ucfirst($pedido->formaPagamento) }}</td>
                    <td>{{ ucfirst($pedido->statusPagamento) }}</td>
                    <td>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total Geral: R$ {{ number_format($total, 2, ',', '.') }}</p>
    </div>
</body>
</html>


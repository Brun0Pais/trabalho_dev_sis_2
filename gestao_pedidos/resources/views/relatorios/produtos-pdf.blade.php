<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #764ba2;
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
            background-color: #764ba2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
        }
        .header-info {
            margin-bottom: 20px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-info">
        <h1>Relatório de Produtos</h1>
        <p><strong>Data de Geração:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total de Produtos:</strong> {{ $totalProdutos }}</p>
        <p><strong>Total em Estoque:</strong> {{ $totalEstoque }} unidades</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ingredientes</th>
                <th>Preço Unit. (R$)</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>#{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ Str::limit($produto->descricao, 50) }}</td>
                    <td>{{ $produto->ingredientesPrincipais ?? 'N/A' }}</td>
                    <td class="text-right">R$ {{ number_format($produto->precoUnidade, 2, ',', '.') }}</td>
                    <td class="text-right">{{ $produto->estoque ? $produto->estoque->quantidadeDisponivel : '0' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total de Produtos Cadastrados: {{ $totalProdutos }}</p>
        <p>Total de Unidades em Estoque: {{ $totalEstoque }}</p>
    </div>
</body>
</html>


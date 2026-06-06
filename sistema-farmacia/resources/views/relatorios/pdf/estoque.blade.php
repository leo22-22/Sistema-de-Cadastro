<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #222; }
    h2 { font-size: 15px; margin-bottom: 4px; }
    .sub { color: #555; font-size: 10px; margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #1e3a5f; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #f5f7fa; }
    .vencido { color: #c0392b; font-weight: bold; }
    .ok { color: #27ae60; }
    .baixo { color: #e67e22; }
</style>
</head>
<body>
<h2>Relatório de Estoque</h2>
<div class="sub">Gerado em {{ now()->format('d/m/Y H:i') }}</div>
<table>
    <thead>
        <tr>
            <th>Medicamento</th><th>Lote</th><th>Qtd Inicial</th><th>Qtd Atual</th><th>Validade</th><th>Entrada</th><th>Situação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lotes as $l)
        @php
            $vencido = $l->validade->isPast();
            $sem = $l->quantidade_atual <= 0;
            $baixo = !$vencido && !$sem && $l->quantidade_atual <= 10;
        @endphp
        <tr>
            <td>{{ $l->medicamento->nome }}</td>
            <td>{{ $l->lote }}</td>
            <td>{{ $l->quantidade_inicial }}</td>
            <td class="{{ $sem ? 'vencido' : ($baixo ? 'baixo' : 'ok') }}">{{ $l->quantidade_atual }}</td>
            <td class="{{ $vencido ? 'vencido' : '' }}">{{ $l->validade->format('d/m/Y') }}</td>
            <td>{{ $l->data_entrada->format('d/m/Y') }}</td>
            <td class="{{ $vencido ? 'vencido' : ($sem ? 'vencido' : ($baixo ? 'baixo' : 'ok')) }}">
                {{ $vencido ? 'Vencido' : ($sem ? 'Sem Estoque' : ($baixo ? 'Baixo' : 'OK')) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #222; }
    h2 { font-size: 15px; margin-bottom: 4px; }
    .sub { color: #555; font-size: 10px; margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #1e3a5f; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #f5f7fa; }
    .totais { margin-top: 12px; font-size: 11px; }
    .totais span { font-weight: bold; }
</style>
</head>
<body>
<h2>Relatório de Dispensações</h2>
<div class="sub">
    Gerado em {{ now()->format('d/m/Y H:i') }}
    @if(!empty($filtros['data_de'])) | De {{ \Carbon\Carbon::parse($filtros['data_de'])->format('d/m/Y') }} @endif
    @if(!empty($filtros['data_ate'])) até {{ \Carbon\Carbon::parse($filtros['data_ate'])->format('d/m/Y') }} @endif
</div>
<table>
    <thead>
        <tr>
            <th>Número</th><th>Data</th><th>Paciente</th><th>Medicamento</th><th>Qtd</th><th>Mês Ref.</th><th>Gerado por</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recibos as $r)
        <tr>
            <td>{{ $r->numero }}</td>
            <td>{{ $r->created_at->format('d/m/Y') }}</td>
            <td>{{ $r->processo->paciente->nome ?? '—' }}</td>
            <td>{{ $r->medicamento->nome ?? '—' }}</td>
            <td>{{ $r->quantidade }}</td>
            <td>{{ $r->mes_referencia ? \Carbon\Carbon::parse($r->mes_referencia)->format('m/Y') : '—' }}</td>
            <td>{{ $r->geradoPor->name ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="totais">Total de registros: <span>{{ $recibos->count() }}</span> | Total de unidades: <span>{{ $total }}</span></div>
</body>
</html>

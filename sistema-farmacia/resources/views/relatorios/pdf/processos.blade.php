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
</style>
</head>
<body>
<h2>Relatório de Processos</h2>
<div class="sub">Gerado em {{ now()->format('d/m/Y H:i') }}</div>
<table>
    <thead>
        <tr>
            <th>Número</th><th>Paciente</th><th>CID</th><th>Tipo</th><th>Abertura</th><th>APAC</th><th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($processos as $p)
        <tr>
            <td>{{ $p->numero }}</td>
            <td>{{ $p->paciente->nome ?? '—' }}</td>
            <td>{{ $p->cid10->codigo ?? '—' }}</td>
            <td>{{ \App\Models\Processo::$tiposProcesso[$p->tipo_processo] ?? $p->tipo_processo }}</td>
            <td>{{ $p->created_at->format('d/m/Y') }}</td>
            <td>{{ $p->validade_apac?->format('d/m/Y') ?? '—' }}</td>
            <td>{{ $p->statusLabel() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:10px;font-size:10px;">Total: {{ $processos->count() }} processos</div>
</body>
</html>

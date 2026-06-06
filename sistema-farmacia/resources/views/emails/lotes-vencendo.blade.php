<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 14px; color: #222; background: #f1f5f9; margin: 0; padding: 20px; }
    .card { background: #fff; border-radius: 10px; padding: 24px 28px; max-width: 640px; margin: 0 auto; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    h2 { font-size: 18px; color: #1e3a5f; margin-bottom: 4px; }
    .sub { color: #64748b; font-size: 12px; margin-bottom: 20px; }
    h3 { font-size: 14px; margin: 20px 0 8px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { background: #1e3a5f; color: #fff; padding: 7px 10px; text-align: left; }
    td { padding: 6px 10px; border-bottom: 1px solid #e5e7eb; }
    .danger { color: #c0392b; font-weight: bold; }
    .warning { color: #d97706; }
    .footer { margin-top: 24px; font-size: 11px; color: #94a3b8; border-top: 1px solid #e5e7eb; padding-top: 12px; }
</style>
</head>
<body>
<div class="card">
    <h2>Alerta Farmácia Municipal</h2>
    <div class="sub">Gerado em {{ now()->format('d/m/Y \à\s H:i') }} | Destinatário: {{ $nomeDestino }}</div>

    @if($lotes30->count())
    <h3 class="danger">⚠ {{ $lotes30->count() }} lote(s) vencem em até 30 dias</h3>
    <table>
        <thead><tr><th>Medicamento</th><th>Lote</th><th>Qtd Atual</th><th>Validade</th></tr></thead>
        <tbody>
            @foreach($lotes30 as $l)
            <tr>
                <td>{{ $l->medicamento->nome }}</td>
                <td>{{ $l->lote }}</td>
                <td class="{{ $l->quantidade_atual <= 10 ? 'warning' : '' }}">{{ $l->quantidade_atual }}</td>
                <td class="danger">{{ $l->validade->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($lotesBaixoEstoque->count())
    <h3 class="warning">⚠ {{ $lotesBaixoEstoque->count() }} lote(s) com estoque baixo (≤ 10 unidades)</h3>
    <table>
        <thead><tr><th>Medicamento</th><th>Lote</th><th>Qtd Atual</th><th>Validade</th></tr></thead>
        <tbody>
            @foreach($lotesBaixoEstoque as $l)
            <tr>
                <td>{{ $l->medicamento->nome }}</td>
                <td>{{ $l->lote }}</td>
                <td class="warning">{{ $l->quantidade_atual }}</td>
                <td>{{ $l->validade->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        Este e-mail foi gerado automaticamente pelo sistema FarmáciaMuni.<br>
        Acesse o painel para mais detalhes.
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo {{ $recibo->numero }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        .recibo-box { max-width: 760px; margin: 20px auto; padding: 32px; border: 2px solid #dee2e6; border-radius: 8px; }
        .label { font-size: 9px; text-transform: uppercase; color: #6c757d; font-weight: 700; letter-spacing: .08em; margin-bottom: 2px; }
        .assinatura-line { border-top: 1px solid #000; padding-top: 5px; margin-top: 50px; font-size: 12px; text-align: center; }
        .apac-badge { display: inline-block; padding: 4px 10px; border: 2px solid; border-radius: 4px; font-weight: 700; font-size: 12px; }
    </style>
</head>
<body>
<div class="recibo-box">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div style="font-size:20px;font-weight:700">Farmácia Municipal</div>
            <div style="font-size:11px;color:#6c757d">Componente Especializado da Assistência Farmacêutica — CEAF/SUS</div>
        </div>
        <div class="text-end">
            <div style="font-size:16px;font-weight:700;color:#198754">RECIBO DE DISPENSAÇÃO</div>
            <div style="font-size:12px;color:#6c757d">Nº {{ $recibo->numero }}</div>
            <div style="font-size:11px;color:#6c757d">Emitido em {{ $recibo->data_emissao->format('d/m/Y') }}</div>
        </div>
    </div>

    <hr>

    {{-- Paciente --}}
    <div class="row mb-3">
        <div class="col-6">
            <div class="label">Paciente</div>
            <div style="font-size:15px;font-weight:700">{{ $recibo->processo->paciente->nome }}</div>
            @if($recibo->processo->paciente->nome_mae)
            <div><span style="color:#6c757d">Mãe:</span> {{ $recibo->processo->paciente->nome_mae }}</div>
            @endif
            @if($recibo->processo->paciente->data_nascimento)
            <div><span style="color:#6c757d">DN:</span> {{ $recibo->processo->paciente->data_nascimento->format('d/m/Y') }}</div>
            @endif
            @if($recibo->processo->paciente->cns)
            <div><span style="color:#6c757d">CNS:</span> {{ $recibo->processo->paciente->cns }}</div>
            @endif
            @if($recibo->processo->paciente->cpf)
            <div><span style="color:#6c757d">CPF:</span> {{ $recibo->processo->paciente->cpf }}</div>
            @endif
        </div>
        <div class="col-6">
            @if($recibo->retirado_por_representante && $recibo->representante)
            <div class="label">Retirado por (Representante Autorizado)</div>
            <div style="font-size:15px;font-weight:700">{{ $recibo->representante->nome }}</div>
            @if($recibo->representante->cpf)<div><span style="color:#6c757d">CPF:</span> {{ $recibo->representante->cpf }}</div>@endif
            @if($recibo->representante->rg)<div><span style="color:#6c757d">RG:</span> {{ $recibo->representante->rg }}</div>@endif
            @else
            <div class="label">Retirado por</div>
            <div style="font-size:14px;font-weight:600">Próprio Paciente</div>
            @endif

            {{-- Validade APAC --}}
            @if($recibo->validade_apac)
            <div class="mt-2">
                <div class="label">Validade APAC</div>
                <span class="apac-badge {{ $recibo->validade_apac->isPast() ? 'border-danger text-danger' : 'border-success text-success' }}">
                    {{ $recibo->validade_apac->format('d/m/Y') }}
                    @if($recibo->validade_apac->isPast()) — VENCIDA @endif
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- Processo --}}
    <div class="mb-3">
        <div class="label">Processo / Diagnóstico</div>
        <div>
            <span style="font-family:monospace;font-weight:700">{{ $recibo->processo->numero }}</span>
            @if($recibo->processo->tipoReceita)
            &nbsp;— {{ $recibo->processo->tipoReceita->nome }}
            @endif
            @if($recibo->processo->cid10)
            &nbsp;| <strong>CID:</strong> {{ $recibo->processo->cid10->codigo }} — {{ $recibo->processo->cid10->nome }}
            @endif
        </div>
        @if($recibo->processo->medicoPrescritor)
        <div style="font-size:12px;color:#6c757d">
            Médico: {{ $recibo->processo->medicoPrescritor->nome }}
            @if($recibo->processo->medicoPrescritor->crm)(CRM: {{ $recibo->processo->medicoPrescritor->crm }})@endif
            @if($recibo->processo->medicoPrescritor->estabelecimento)— {{ $recibo->processo->medicoPrescritor->estabelecimento }}@endif
        </div>
        @endif
    </div>

    {{-- Medicamento dispensado --}}
    <div class="mb-3">
        <div class="label">Medicamento Dispensado</div>
        <table class="table table-sm table-bordered mt-1 mb-0">
            <thead class="table-light">
                <tr>
                    <th>Medicamento</th>
                    <th class="text-center" width="60">Qtd</th>
                    <th width="100">Mês Ref.</th>
                    <th width="110">Lote</th>
                    <th width="70">Validade Lote</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight:600">
                        {{ $recibo->medicamento->nome ?? '—' }}
                        @if($recibo->medicamento?->dosagem) — {{ $recibo->medicamento->dosagem }} @endif
                        @if($recibo->medicamento?->forma_label) ({{ $recibo->medicamento->forma_label }}) @endif
                    </td>
                    <td class="text-center">{{ $recibo->quantidade }}</td>
                    <td>{{ $recibo->mes_referencia?->format('m/Y') ?? '—' }}</td>
                    <td>{{ $recibo->lote?->lote ?? '—' }}</td>
                    <td>{{ $recibo->lote?->validade?->format('d/m/Y') ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Declaração autorizadora --}}
    @if($recibo->processo->paciente->representantes->count())
    <div class="mb-3">
        <div class="label">Declaração Autorizadora — Representantes Cadastrados</div>
        <div style="font-size:11px;color:#555">
            @foreach($recibo->processo->paciente->representantes as $rep)
            <span style="margin-right:16px">{{ $loop->iteration }}º {{ $rep->nome }}{{ $rep->cpf ? ' (CPF: ' . $rep->cpf . ')' : '' }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @if($recibo->observacoes)
    <div class="mb-3">
        <div class="label">Observações</div>
        <div style="color:#555">{{ $recibo->observacoes }}</div>
    </div>
    @endif

    <hr>

    {{-- Assinaturas --}}
    <div class="row mt-2">
        <div class="col-4">
            <div class="assinatura-line">Farmacêutico Responsável</div>
        </div>
        <div class="col-4">
            <div class="assinatura-line">
                {{ $recibo->retirado_por_representante ? 'Representante' : 'Paciente' }}
            </div>
        </div>
        <div class="col-4">
            <div class="assinatura-line">Data: ___/___/______</div>
        </div>
    </div>

    <div style="font-size:10px;color:#aaa;text-align:right;margin-top:12px">
        Gerado por {{ $recibo->geradoPor->name }} — {{ $recibo->created_at->format('d/m/Y H:i') }}
    </div>
</div>

<div class="text-center mt-3 no-print">
    <button onclick="window.print()" class="btn btn-primary">
        <i class="bi bi-printer me-1"></i>Imprimir
    </button>
    <a href="{{ route('recibos.show', $recibo) }}" class="btn btn-outline-secondary ms-2">Voltar</a>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

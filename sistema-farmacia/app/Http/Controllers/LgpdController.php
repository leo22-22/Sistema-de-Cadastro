<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\JsonResponse;

class LgpdController extends Controller
{
    public function exportar(Paciente $paciente): JsonResponse
    {
        $user = auth()->user();
        if (!$user->isSuperadmin() && !$user->isAdminFarmacia()) {
            abort(403, 'Acesso não autorizado.');
        }

        $paciente->load(['representantes', 'alergias']);

        $processosQuery = $paciente->processos()->with([
            'cid10', 'medicoPrescritor', 'medicamentos',
            'recibos.medicamento', 'recibos.geradoPor',
        ]);
        if (!$user->isSuperadmin()) {
            $processosQuery->where('farmacia_id', $user->farmacia_id);
        }
        $paciente->setRelation('processos', $processosQuery->get());

        $dados = [
            'exportado_em'  => now()->toIso8601String(),
            'exportado_por' => $user->name . ' (' . $user->email . ')',
            'sistema'       => 'GovSaúde',
            'base_legal_lgpd' => 'Art. 7º, III e Art. 11, II, "a" da Lei 13.709/2018 — tratamento para tutela da saúde',
            'paciente' => [
                'id'               => $paciente->id,
                'nome'             => $paciente->nome,
                'nome_mae'         => $paciente->nome_mae,
                'cpf'              => $paciente->cpf,
                'rg'               => $paciente->rg,
                'cns'              => $paciente->cns,
                'prontuario'       => $paciente->prontuario,
                'data_nascimento'  => $paciente->data_nascimento?->format('Y-m-d'),
                'raca_cor'         => $paciente->raca_cor,
                'peso'             => $paciente->peso,
                'altura'           => $paciente->altura,
                'telefone'         => $paciente->telefone,
                'email'            => $paciente->email,
                'endereco'         => $paciente->endereco_completo,
                'ativo'            => $paciente->ativo,
                'criado_em'        => $paciente->created_at?->toIso8601String(),
            ],
            'representantes' => $paciente->representantes->map(fn($r) => [
                'nome'     => $r->nome,
                'cpf'      => $r->cpf,
                'telefone' => $r->telefone,
                'ordem'    => $r->pivot->ordem,
            ]),
            'alergias' => $paciente->alergias->map(fn($a) => [
                'tipo'      => $a->tipo,
                'descricao' => $a->descricao,
                'gravidade' => $a->gravidade,
                'reacao'    => $a->reacao,
            ]),
            'processos' => $paciente->processos->map(fn($p) => [
                'numero'          => $p->numero,
                'tipo'            => $p->tipo_processo,
                'status'          => $p->status,
                'cid'             => $p->cid10?->codigo . ' — ' . $p->cid10?->nome,
                'medico'          => $p->medicoPrescritor?->nome,
                'data_receita'    => $p->data_receita?->format('Y-m-d'),
                'validade_apac'   => $p->validade_apac?->format('Y-m-d'),
                'medicamentos'    => $p->medicamentos->map(fn($m) => $m->nome_completo),
                'dispensacoes'    => $p->recibos->map(fn($r) => [
                    'numero'         => $r->numero,
                    'data'           => $r->data_emissao?->format('Y-m-d'),
                    'medicamento'    => $r->medicamento?->nome,
                    'quantidade'     => $r->quantidade,
                    'mes_referencia' => $r->mes_referencia?->format('Y-m'),
                    'gerado_por'     => $r->geradoPor?->name,
                ]),
            ]),
        ];

        return response()->json($dados, 200, [
            'Content-Disposition' => 'attachment; filename="lgpd_paciente_' . $paciente->id . '_' . now()->format('Y-m-d') . '.json"',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

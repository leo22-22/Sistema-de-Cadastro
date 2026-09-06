<?php

namespace App\Http\Controllers;

use App\Models\Cid10;
use App\Models\Medicamento;
use App\Models\MedicoPrescritor;
use App\Models\Paciente;
use App\Models\Processo;
use App\Models\ProcessoDocumento;
use App\Models\TipoReceita;
use App\Models\TipoRelacaoRemessa;
use App\Notifications\ProcessoStatusNotification;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProcessoController extends Controller
{
    private function escopoFarmacia($query)
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            $query->where('farmacia_id', $user->farmacia_id);
        }
        return $query;
    }

    private function autorizarProcesso(Processo $processo): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            abort_if($processo->farmacia_id !== $user->farmacia_id, 403);
        }
    }

    public function index(Request $request)
    {
        $query = $this->escopoFarmacia(Processo::with(['paciente', 'cid10', 'criadoPor']));

        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('numero', 'like', "%{$request->busca}%")
                  ->orWhereHas('paciente', fn($p) => $p->where('nome', 'like', "%{$request->busca}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo_processo')) {
            $query->where('tipo_processo', $request->tipo_processo);
        }

        $processos = $query->latest()->paginate(15)->withQueryString();
        return view('processos.index', compact('processos'));
    }

    public function create()
    {
        $farmaciaId     = auth()->user()->farmacia_id;
        $pacientes      = Paciente::ativo()->orderBy('nome')->get();
        $cids           = Cid10::ativo()->orderBy('codigo')->get();
        $medicos        = MedicoPrescritor::ativo()->orderBy('nome')->get();
        $tiposReceita   = TipoReceita::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->get();
        $tiposRemessa   = TipoRelacaoRemessa::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->get();
        $medicamentos   = Medicamento::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->with('tipoReceita')->get();
        $tiposProcesso  = Processo::$tiposProcesso;

        return view('processos.create', compact(
            'pacientes', 'cids', 'medicos', 'tiposReceita',
            'tiposRemessa', 'medicamentos', 'tiposProcesso'
        ));
    }

    public function store(Request $request)
    {
        $farmaciaId = auth()->user()->farmacia_id;

        $request->validate([
            'tipo_processo'            => ['nullable', 'in:abertura,retratado,transferencia,renovacao,continuidade'],
            'paciente_id'              => ['nullable', 'exists:pacientes,id'],
            'cid10_id'                 => ['nullable', 'exists:cid10,id'],
            'medico_prescritor_id'     => ['nullable', 'exists:medicos_prescritores,id'],
            'tipo_receita_id'          => ['nullable', Rule::exists('tipos_receita', 'id')->where('farmacia_id', $farmaciaId)],
            'tipo_relacao_remessa_id'  => ['nullable', Rule::exists('tipos_relacao_remessa', 'id')->where('farmacia_id', $farmaciaId)],
            'numero_receita'           => ['nullable', 'string', 'max:100'],
            'data_receita'             => ['nullable', 'date'],
            'data_validade_receita'    => ['nullable', 'date', 'after_or_equal:data_receita'],
            'observacoes'              => ['nullable', 'string'],
            'lme_entregue'             => ['boolean'],
            'receita_entregue'         => ['boolean'],
            'exame_entregue'           => ['boolean'],
            'documentos_entregues'     => ['boolean'],
            'medicamentos'             => ['nullable', 'array'],
            'medicamentos.*.id'           => ['required', Rule::exists('medicamentos', 'id')->where('farmacia_id', $farmaciaId)],
            'medicamentos.*.periodicidade'=> ['nullable', 'in:mensal,bimestral,trimestral'],
            'medicamentos.*.quantidade_diaria' => ['nullable', 'numeric', 'min:0.1'],
            'medicamentos.*.quantidade_mensal' => ['nullable', 'integer', 'min:1'],
            'medicamentos.*.posologia'    => ['nullable', 'string', 'max:255'],
            'medicamentos.*.observacoes'  => ['nullable', 'string', 'max:255'],
        ]);

        $processo = DB::transaction(function () use ($request) {
            $processo = Processo::create([
                'numero'                  => Processo::gerarNumero(),
                'tipo_processo'           => $request->tipo_processo,
                'paciente_id'             => $request->paciente_id,
                'cid10_id'                => $request->cid10_id,
                'medico_prescritor_id'    => $request->medico_prescritor_id,
                'tipo_receita_id'         => $request->tipo_receita_id,
                'tipo_relacao_remessa_id' => $request->tipo_relacao_remessa_id,
                'numero_receita'          => $request->numero_receita,
                'data_receita'            => $request->data_receita,
                'data_validade_receita'   => $request->data_validade_receita,
                'lme_entregue'            => $request->boolean('lme_entregue'),
                'receita_entregue'        => $request->boolean('receita_entregue'),
                'exame_entregue'          => $request->boolean('exame_entregue'),
                'documentos_entregues'    => $request->boolean('documentos_entregues'),
                'observacoes'             => $request->observacoes,
                'status'                  => 'aberto',
                'created_by'              => auth()->id(),
                'farmacia_id'             => auth()->user()->farmacia_id,
            ]);

            foreach ($request->medicamentos ?? [] as $item) {
                $processo->medicamentos()->attach($item['id'], [
                    'periodicidade'     => $item['periodicidade'] ?? 'mensal',
                    'quantidade_diaria' => $item['quantidade_diaria'] ?? null,
                    'quantidade_mensal' => $item['quantidade_mensal'] ?? null,
                    'posologia'         => $item['posologia'] ?? null,
                    'observacoes'       => $item['observacoes'] ?? null,
                ]);
            }

            return $processo;
        });

        AuditoriaService::log('criar', "Processo {$processo->numero} criado para paciente " . ($processo->paciente->nome ?? 'não informado'), 'Processo', $processo->id);

        return redirect()->route('processos.show', $processo)
            ->with('success', 'Processo aberto com sucesso.');
    }

    public function show(Processo $processo)
    {
        $this->autorizarProcesso($processo);

        $processo->load([
            'paciente.representantes',
            'cid10',
            'medicoPrescritor',
            'tipoReceita',
            'tipoRelacaoRemessa',
            'medicamentos',
            'documentos.enviador',
            'criadoPor',
            'recibos.medicamento',
        ]);
        return view('processos.show', compact('processo'));
    }

    public function edit(Processo $processo)
    {
        $this->autorizarProcesso($processo);

        if (in_array($processo->status, ['cancelado'])) {
            return back()->with('error', 'Processos cancelados não podem ser editados.');
        }

        $processo->load('medicamentos');
        $farmaciaId    = auth()->user()->farmacia_id;
        $pacientes     = Paciente::ativo()->orderBy('nome')->get();
        $cids          = Cid10::ativo()->orderBy('codigo')->get();
        $medicos       = MedicoPrescritor::ativo()->orderBy('nome')->get();
        $tiposReceita  = TipoReceita::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->get();
        $tiposRemessa  = TipoRelacaoRemessa::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->get();
        $medicamentos  = Medicamento::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->with('tipoReceita')->get();
        $tiposProcesso = Processo::$tiposProcesso;

        return view('processos.edit', compact(
            'processo', 'pacientes', 'cids', 'medicos',
            'tiposReceita', 'tiposRemessa', 'medicamentos', 'tiposProcesso'
        ));
    }

    public function update(Request $request, Processo $processo)
    {
        $this->autorizarProcesso($processo);

        if ($processo->status === 'cancelado') {
            return back()->with('error', 'Processos cancelados não podem ser editados.');
        }

        $farmaciaId = auth()->user()->farmacia_id;

        $request->validate([
            'tipo_processo'            => ['nullable', 'in:abertura,retratado,transferencia,renovacao,continuidade'],
            'paciente_id'              => ['nullable', 'exists:pacientes,id'],
            'cid10_id'                 => ['nullable', 'exists:cid10,id'],
            'medico_prescritor_id'     => ['nullable', 'exists:medicos_prescritores,id'],
            'tipo_receita_id'          => ['nullable', Rule::exists('tipos_receita', 'id')->where('farmacia_id', $farmaciaId)],
            'tipo_relacao_remessa_id'  => ['nullable', Rule::exists('tipos_relacao_remessa', 'id')->where('farmacia_id', $farmaciaId)],
            'numero_receita'           => ['nullable', 'string', 'max:100'],
            'data_receita'             => ['nullable', 'date'],
            'data_validade_receita'    => ['nullable', 'date', 'after_or_equal:data_receita'],
            'data_primeira_retirada'   => ['nullable', 'date'],
            'observacoes'              => ['nullable', 'string'],
            'lme_entregue'             => ['boolean'],
            'receita_entregue'         => ['boolean'],
            'exame_entregue'           => ['boolean'],
            'documentos_entregues'     => ['boolean'],
            'medicamentos'             => ['nullable', 'array'],
            'medicamentos.*.id'           => ['required', Rule::exists('medicamentos', 'id')->where('farmacia_id', $farmaciaId)],
            'medicamentos.*.periodicidade'=> ['nullable', 'in:mensal,bimestral,trimestral'],
            'medicamentos.*.quantidade_diaria' => ['nullable', 'numeric', 'min:0.1'],
            'medicamentos.*.quantidade_mensal' => ['nullable', 'integer', 'min:1'],
            'medicamentos.*.posologia'    => ['nullable', 'string', 'max:255'],
            'medicamentos.*.observacoes'  => ['nullable', 'string', 'max:255'],
        ]);

        $dataPrimeiraRetirada = $request->data_primeira_retirada;
        $validadeApac         = $dataPrimeiraRetirada
            ? \Carbon\Carbon::parse($dataPrimeiraRetirada)->addMonths(6)->toDateString()
            : null;

        DB::transaction(function () use ($request, $processo, $dataPrimeiraRetirada, $validadeApac) {
            $processo->update([
                'tipo_processo'           => $request->tipo_processo,
                'paciente_id'             => $request->paciente_id,
                'cid10_id'                => $request->cid10_id,
                'medico_prescritor_id'    => $request->medico_prescritor_id,
                'tipo_receita_id'         => $request->tipo_receita_id,
                'tipo_relacao_remessa_id' => $request->tipo_relacao_remessa_id,
                'numero_receita'          => $request->numero_receita,
                'data_receita'            => $request->data_receita,
                'data_validade_receita'   => $request->data_validade_receita,
                'data_primeira_retirada'  => $dataPrimeiraRetirada,
                'validade_apac'           => $validadeApac,
                'lme_entregue'            => $request->boolean('lme_entregue'),
                'receita_entregue'        => $request->boolean('receita_entregue'),
                'exame_entregue'          => $request->boolean('exame_entregue'),
                'documentos_entregues'    => $request->boolean('documentos_entregues'),
                'observacoes'             => $request->observacoes,
            ]);

            $sync = [];
            foreach ($request->medicamentos ?? [] as $item) {
                $sync[$item['id']] = [
                    'periodicidade'     => $item['periodicidade'] ?? 'mensal',
                    'quantidade_diaria' => $item['quantidade_diaria'] ?? null,
                    'quantidade_mensal' => $item['quantidade_mensal'] ?? null,
                    'posologia'         => $item['posologia'] ?? null,
                    'observacoes'       => $item['observacoes'] ?? null,
                ];
            }
            $processo->medicamentos()->sync($sync);
        });

        AuditoriaService::log('editar', "Processo {$processo->numero} atualizado", 'Processo', $processo->id);

        return redirect()->route('processos.show', $processo)
            ->with('success', 'Processo atualizado com sucesso.');
    }

    public function destroy(Processo $processo)
    {
        $this->autorizarProcesso($processo);

        if ($processo->recibos()->exists()) {
            return back()->with('error', 'Não é possível excluir um processo com recibos gerados.');
        }
        AuditoriaService::log('excluir', "Processo {$processo->numero} excluído", 'Processo', $processo->id);

        $processo->documentos->each(fn($doc) => Storage::delete($doc->arquivo));
        $processo->medicamentos()->detach();
        $processo->delete();

        return redirect()->route('processos.index')->with('success', 'Processo removido.');
    }

    public function atualizarStatus(Request $request, Processo $processo)
    {
        $this->autorizarProcesso($processo);

        $request->validate(['status' => ['required', 'in:aberto,em_andamento,concluido,cancelado']]);

        $novoStatus = $request->status;

        if ($processo->status === 'cancelado') {
            return back()->with('error', 'Um processo cancelado não pode ter o status alterado.');
        }

        if ($novoStatus === 'cancelado' && !$processo->podeCancelar()) {
            return back()->with('error', 'Este processo não pode ser cancelado.');
        }

        if ($novoStatus === 'concluido' && !$processo->podeConcluir()) {
            return back()->with('error', 'Este processo não pode ser concluído no status atual.');
        }

        $updates = [
            'status'            => $novoStatus,
            'updated_by'        => auth()->id(),
            'status_updated_at' => now(),
        ];

        if ($novoStatus === 'em_andamento' && !$processo->data_primeira_retirada) {
            $hoje = now()->toDateString();
            $updates['data_primeira_retirada'] = $hoje;
            $updates['validade_apac']           = now()->addMonths(6)->toDateString();
        }

        $statusAnterior = $processo->statusLabel();
        $processo->update($updates);
        AuditoriaService::log('status', "Processo {$processo->numero} → status '{$novoStatus}'", 'Processo', $processo->id);

        // Notifica o criador do processo se for diferente de quem mudou o status
        $criador = $processo->criadoPor;
        if ($criador && $criador->id !== auth()->id()) {
            $criador->notify(new ProcessoStatusNotification($processo->fresh(), $statusAnterior));
        }

        return back()->with('success', 'Status atualizado para "' . $processo->fresh()->statusLabel() . '".');
    }

    public function uploadDocumento(Request $request, Processo $processo)
    {
        $this->autorizarProcesso($processo);

        $request->validate([
            'tipo'    => ['required', 'in:lme,receita,exame,documento_pessoal,outro'],
            'arquivo' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $file  = $request->file('arquivo');
        $path  = $file->store("processos/{$processo->id}", 'local');

        ProcessoDocumento::create([
            'processo_id'  => $processo->id,
            'tipo'         => $request->tipo,
            'nome_original'=> $file->getClientOriginalName(),
            'arquivo'      => $path,
            'tamanho'      => $file->getSize(),
            'mime_type'    => $file->getMimeType(),
            'enviado_por'  => auth()->id(),
        ]);

        // Marca o documento como entregue automaticamente
        $campo = match($request->tipo) {
            'lme'              => 'lme_entregue',
            'receita'          => 'receita_entregue',
            'exame'            => 'exame_entregue',
            'documento_pessoal'=> 'documentos_entregues',
            default            => null,
        };
        if ($campo) $processo->update([$campo => true]);

        return back()->with('success', 'Arquivo enviado com sucesso.');
    }

    public function deleteDocumento(Processo $processo, ProcessoDocumento $documento)
    {
        $this->autorizarProcesso($processo);
        abort_if($documento->processo_id !== $processo->id, 404);

        Storage::delete($documento->arquivo);
        $documento->delete();
        return back()->with('success', 'Documento removido.');
    }

    public function renovar(Processo $processo)
    {
        $this->autorizarProcesso($processo);

        $novo = DB::transaction(function () use ($processo) {
            $novo = Processo::create([
                'numero'                  => Processo::gerarNumero(),
                'tipo_processo'           => 'renovacao',
                'paciente_id'             => $processo->paciente_id,
                'cid10_id'                => $processo->cid10_id,
                'medico_prescritor_id'    => $processo->medico_prescritor_id,
                'tipo_receita_id'         => $processo->tipo_receita_id,
                'tipo_relacao_remessa_id' => $processo->tipo_relacao_remessa_id,
                'observacoes'             => $processo->observacoes,
                'lme_entregue'            => false,
                'receita_entregue'        => false,
                'exame_entregue'          => false,
                'documentos_entregues'    => false,
                'status'                  => 'aberto',
                'created_by'              => auth()->id(),
                'farmacia_id'             => $processo->farmacia_id,
            ]);

            foreach ($processo->medicamentos as $med) {
                $novo->medicamentos()->attach($med->id, [
                    'periodicidade'     => $med->pivot->periodicidade,
                    'quantidade_diaria' => $med->pivot->quantidade_diaria,
                    'quantidade_mensal' => $med->pivot->quantidade_mensal,
                    'posologia'         => $med->pivot->posologia,
                    'observacoes'       => $med->pivot->observacoes,
                ]);
            }

            return $novo;
        });

        AuditoriaService::log('renovar', "Processo {$novo->numero} criado por renovação de {$processo->numero}", 'Processo', $novo->id);

        return redirect()->route('processos.show', $novo)
            ->with('success', "Processo de renovação {$novo->numero} criado a partir de {$processo->numero}.");
    }
}

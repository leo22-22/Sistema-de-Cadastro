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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessoController extends Controller
{
    private function escopoFarmacia($query)
    {
        $user = auth()->user();
        if (!$user->isSuperadmin() && $user->farmacia_id) {
            $query->where('farmacia_id', $user->farmacia_id);
        }
        return $query;
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
        $pacientes      = Paciente::ativo()->orderBy('nome')->get();
        $cids           = Cid10::ativo()->orderBy('codigo')->get();
        $medicos        = MedicoPrescritor::ativo()->orderBy('nome')->get();
        $tiposReceita   = TipoReceita::ativo()->orderBy('nome')->get();
        $tiposRemessa   = TipoRelacaoRemessa::ativo()->orderBy('nome')->get();
        $medicamentos   = Medicamento::ativo()->orderBy('nome')->with('tipoReceita')->get();
        $tiposProcesso  = Processo::$tiposProcesso;

        return view('processos.create', compact(
            'pacientes', 'cids', 'medicos', 'tiposReceita',
            'tiposRemessa', 'medicamentos', 'tiposProcesso'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_processo'            => ['required', 'in:abertura,retratado,transferencia,renovacao,continuidade'],
            'paciente_id'              => ['required', 'exists:pacientes,id'],
            'cid10_id'                 => ['required', 'exists:cid10,id'],
            'medico_prescritor_id'     => ['nullable', 'exists:medicos_prescritores,id'],
            'tipo_receita_id'          => ['nullable', 'exists:tipos_receita,id'],
            'tipo_relacao_remessa_id'  => ['nullable', 'exists:tipos_relacao_remessa,id'],
            'numero_receita'           => ['nullable', 'string', 'max:100'],
            'data_receita'             => ['nullable', 'date'],
            'data_validade_receita'    => ['nullable', 'date', 'after_or_equal:data_receita'],
            'observacoes'              => ['nullable', 'string'],
            'lme_entregue'             => ['boolean'],
            'receita_entregue'         => ['boolean'],
            'exame_entregue'           => ['boolean'],
            'documentos_entregues'     => ['boolean'],
            'medicamentos'             => ['required', 'array', 'min:1'],
            'medicamentos.*.id'           => ['required', 'exists:medicamentos,id'],
            'medicamentos.*.periodicidade'=> ['required', 'in:mensal,bimestral,trimestral'],
            'medicamentos.*.quantidade_diaria' => ['nullable', 'numeric', 'min:0.1'],
            'medicamentos.*.quantidade_mensal' => ['nullable', 'integer', 'min:1'],
            'medicamentos.*.posologia'    => ['nullable', 'string', 'max:255'],
            'medicamentos.*.observacoes'  => ['nullable', 'string', 'max:255'],
        ]);

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

        foreach ($request->medicamentos as $item) {
            $processo->medicamentos()->attach($item['id'], [
                'periodicidade'     => $item['periodicidade'] ?? 'mensal',
                'quantidade_diaria' => $item['quantidade_diaria'] ?? null,
                'quantidade_mensal' => $item['quantidade_mensal'] ?? null,
                'posologia'         => $item['posologia'] ?? null,
                'observacoes'       => $item['observacoes'] ?? null,
            ]);
        }

        return redirect()->route('processos.show', $processo)
            ->with('success', 'Processo aberto com sucesso.');
    }

    public function show(Processo $processo)
    {
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
        if (in_array($processo->status, ['cancelado'])) {
            return back()->with('error', 'Processos cancelados não podem ser editados.');
        }

        $processo->load('medicamentos');
        $pacientes     = Paciente::ativo()->orderBy('nome')->get();
        $cids          = Cid10::ativo()->orderBy('codigo')->get();
        $medicos       = MedicoPrescritor::ativo()->orderBy('nome')->get();
        $tiposReceita  = TipoReceita::ativo()->orderBy('nome')->get();
        $tiposRemessa  = TipoRelacaoRemessa::ativo()->orderBy('nome')->get();
        $medicamentos  = Medicamento::ativo()->orderBy('nome')->with('tipoReceita')->get();
        $tiposProcesso = Processo::$tiposProcesso;

        return view('processos.edit', compact(
            'processo', 'pacientes', 'cids', 'medicos',
            'tiposReceita', 'tiposRemessa', 'medicamentos', 'tiposProcesso'
        ));
    }

    public function update(Request $request, Processo $processo)
    {
        if ($processo->status === 'cancelado') {
            return back()->with('error', 'Processos cancelados não podem ser editados.');
        }

        $request->validate([
            'tipo_processo'            => ['required', 'in:abertura,retratado,transferencia,renovacao,continuidade'],
            'paciente_id'              => ['required', 'exists:pacientes,id'],
            'cid10_id'                 => ['required', 'exists:cid10,id'],
            'medico_prescritor_id'     => ['nullable', 'exists:medicos_prescritores,id'],
            'tipo_receita_id'          => ['nullable', 'exists:tipos_receita,id'],
            'tipo_relacao_remessa_id'  => ['nullable', 'exists:tipos_relacao_remessa,id'],
            'numero_receita'           => ['nullable', 'string', 'max:100'],
            'data_receita'             => ['nullable', 'date'],
            'data_validade_receita'    => ['nullable', 'date', 'after_or_equal:data_receita'],
            'data_primeira_retirada'   => ['nullable', 'date'],
            'observacoes'              => ['nullable', 'string'],
            'lme_entregue'             => ['boolean'],
            'receita_entregue'         => ['boolean'],
            'exame_entregue'           => ['boolean'],
            'documentos_entregues'     => ['boolean'],
            'medicamentos'             => ['required', 'array', 'min:1'],
            'medicamentos.*.id'           => ['required', 'exists:medicamentos,id'],
            'medicamentos.*.periodicidade'=> ['required', 'in:mensal,bimestral,trimestral'],
            'medicamentos.*.quantidade_diaria' => ['nullable', 'numeric', 'min:0.1'],
            'medicamentos.*.quantidade_mensal' => ['nullable', 'integer', 'min:1'],
            'medicamentos.*.posologia'    => ['nullable', 'string', 'max:255'],
            'medicamentos.*.observacoes'  => ['nullable', 'string', 'max:255'],
        ]);

        $dataPrimeiraRetirada = $request->data_primeira_retirada;
        $validadeApac         = $dataPrimeiraRetirada
            ? \Carbon\Carbon::parse($dataPrimeiraRetirada)->addMonths(6)->toDateString()
            : null;

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
        foreach ($request->medicamentos as $item) {
            $sync[$item['id']] = [
                'periodicidade'     => $item['periodicidade'] ?? 'mensal',
                'quantidade_diaria' => $item['quantidade_diaria'] ?? null,
                'quantidade_mensal' => $item['quantidade_mensal'] ?? null,
                'posologia'         => $item['posologia'] ?? null,
                'observacoes'       => $item['observacoes'] ?? null,
            ];
        }
        $processo->medicamentos()->sync($sync);

        return redirect()->route('processos.show', $processo)
            ->with('success', 'Processo atualizado com sucesso.');
    }

    public function destroy(Processo $processo)
    {
        if ($processo->recibos()->exists()) {
            return back()->with('error', 'Não é possível excluir um processo com recibos gerados.');
        }
        $processo->documentos->each(fn($doc) => Storage::delete($doc->arquivo));
        $processo->medicamentos()->detach();
        $processo->delete();

        return redirect()->route('processos.index')->with('success', 'Processo removido.');
    }

    public function atualizarStatus(Request $request, Processo $processo)
    {
        $request->validate(['status' => ['required', 'in:aberto,em_andamento,concluido,cancelado']]);

        $novoStatus = $request->status;

        if ($novoStatus === 'cancelado' && !$processo->podeCancelar()) {
            return back()->with('error', 'Este processo não pode ser cancelado.');
        }

        $updates = ['status' => $novoStatus];

        if ($novoStatus === 'em_andamento' && !$processo->data_primeira_retirada) {
            $hoje = now()->toDateString();
            $updates['data_primeira_retirada'] = $hoje;
            $updates['validade_apac']           = now()->addMonths(6)->toDateString();
        }

        $processo->update($updates);
        return back()->with('success', 'Status atualizado para "' . $processo->fresh()->statusLabel() . '".');
    }

    public function uploadDocumento(Request $request, Processo $processo)
    {
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
        Storage::delete($documento->arquivo);
        $documento->delete();
        return back()->with('success', 'Documento removido.');
    }
}

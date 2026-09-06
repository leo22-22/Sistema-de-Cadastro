<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Medicamento;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    private function escopoFarmacia($query)
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            $query->where('farmacia_id', $user->farmacia_id);
        }
        return $query;
    }

    private function autorizarLote(Lote $lote): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            abort_if($lote->farmacia_id !== $user->farmacia_id, 403);
        }
    }

    public function index(Request $request)
    {
        $query = $this->escopoFarmacia(Lote::with('medicamento', 'criadoPor'));
        if ($request->filled('medicamento_id')) {
            $query->where('medicamento_id', $request->medicamento_id);
        }
        if ($request->filled('vencidos')) {
            $query->where('validade', '<', now());
        }
        $lotes = $query->latest()->paginate(20)->withQueryString();
        $medicamentos = Medicamento::ativo()->where('farmacia_id', auth()->user()->farmacia_id)->orderBy('nome')->get();
        return view('lotes.index', compact('lotes', 'medicamentos'));
    }

    public function create()
    {
        $medicamentos = Medicamento::ativo()->where('farmacia_id', auth()->user()->farmacia_id)->orderBy('nome')->get();
        return view('lotes.create', compact('medicamentos'));
    }

    public function store(Request $request)
    {
        $farmaciaId = auth()->user()->farmacia_id;

        $data = $request->validate([
            'medicamento_id'    => ['nullable', \Illuminate\Validation\Rule::exists('medicamentos', 'id')->where('farmacia_id', $farmaciaId)],
            'lote'              => ['nullable', 'string', 'max:50', \Illuminate\Validation\Rule::unique('lotes')->where('medicamento_id', $request->medicamento_id)->where('farmacia_id', $farmaciaId)],
            'validade'          => 'nullable|date',
            'quantidade_inicial'=> 'nullable|integer|min:0',
            'data_entrada'      => 'nullable|date',
            'observacoes'       => 'nullable|string',
        ]);

        $data['quantidade_atual'] = $data['quantidade_inicial'] ?? 0;
        $data['farmacia_id']      = $farmaciaId;
        $data['created_by']       = auth()->id();
        $lote = Lote::create($data);
        AuditoriaService::log('criar', "Lote {$lote->lote} cadastrado para " . ($lote->medicamento->nome ?? 'medicamento não informado'), 'Lote', $lote->id);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote cadastrado com sucesso.');
    }

    public function show(Lote $lote)
    {
        $this->autorizarLote($lote);
        $lote->load('medicamento', 'recibos.processo.paciente');
        return view('lotes.show', compact('lote'));
    }

    public function edit(Lote $lote)
    {
        $this->autorizarLote($lote);
        $medicamentos = Medicamento::ativo()->where('farmacia_id', auth()->user()->farmacia_id)->orderBy('nome')->get();
        return view('lotes.edit', compact('lote', 'medicamentos'));
    }

    public function update(Request $request, Lote $lote)
    {
        $this->autorizarLote($lote);

        $data = $request->validate([
            'lote'          => ['nullable', 'string', 'max:50', \Illuminate\Validation\Rule::unique('lotes')->where('medicamento_id', $lote->medicamento_id)->where('farmacia_id', $lote->farmacia_id)->ignore($lote->id)],
            'validade'      => 'nullable|date',
            'observacoes'   => 'nullable|string',
        ]);

        $lote->update($data);
        return redirect()->route('lotes.index')
            ->with('success', 'Lote atualizado.');
    }

    public function destroy(Lote $lote)
    {
        $this->autorizarLote($lote);

        if ($lote->recibos()->exists()) {
            return back()->with('error', 'Lote possui dispensações registradas e não pode ser removido.');
        }
        AuditoriaService::log('excluir', "Lote {$lote->lote} removido", 'Lote', $lote->id);
        $lote->delete();
        return back()->with('success', 'Lote removido.');
    }
}

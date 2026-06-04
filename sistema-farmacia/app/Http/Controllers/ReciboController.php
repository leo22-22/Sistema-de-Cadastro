<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Processo;
use App\Models\Recibo;
use App\Models\Representante;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    public function index(Request $request)
    {
        $query = Recibo::with(['processo.paciente', 'medicamento', 'geradoPor']);

        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('numero', 'like', "%{$request->busca}%")
                  ->orWhereHas('processo.paciente', fn($p) => $p->where('nome', 'like', "%{$request->busca}%"));
            });
        }

        if ($request->filled('mes')) {
            $query->whereYear('mes_referencia', substr($request->mes, 0, 4))
                  ->whereMonth('mes_referencia', substr($request->mes, 5, 2));
        }

        $recibos = $query->latest()->paginate(15)->withQueryString();
        return view('recibos.index', compact('recibos'));
    }

    public function create(Processo $processo)
    {
        $processo->load(['paciente.representantes', 'cid10', 'medicamentos', 'medicoPrescritor']);

        $medicamentosIds = $processo->medicamentos->pluck('id');
        $lotes = Lote::whereIn('medicamento_id', $medicamentosIds)
            ->where('quantidade_atual', '>', 0)
            ->where('validade', '>', now())
            ->with('medicamento')
            ->orderBy('validade')
            ->get()
            ->groupBy('medicamento_id');

        return view('recibos.create', compact('processo', 'lotes'));
    }

    public function store(Request $request, Processo $processo)
    {
        $medicamentosDoProcesso = $processo->medicamentos->pluck('id')->toArray();

        $request->validate([
            'medicamento_id'             => ['required', 'exists:medicamentos,id', \Illuminate\Validation\Rule::in($medicamentosDoProcesso)],
            'lote_id'                    => ['nullable', 'exists:lotes,id'],
            'mes_referencia'             => ['required', 'date', 'before_or_equal:today'],
            'quantidade'                 => ['required', 'integer', 'min:1'],
            'retirado_por_representante' => ['boolean'],
            'representante_id'           => ['required_if:retirado_por_representante,1', 'nullable', 'exists:representantes,id'],
            'observacoes'                => ['nullable', 'string'],
        ], [
            'medicamento_id.in'              => 'O medicamento selecionado não pertence a este processo.',
            'representante_id.required_if'  => 'Informe o representante que está retirando.',
            'mes_referencia.before_or_equal' => 'O mês de referência não pode ser no futuro.',
        ]);

        $lote = $request->lote_id ? Lote::find($request->lote_id) : null;

        if ($lote) {
            if ($lote->quantidade_atual < $request->quantidade) {
                return back()->with('error', "Estoque insuficiente. Disponível: {$lote->quantidade_atual} unidades.");
            }
            $lote->decrement('quantidade_atual', $request->quantidade);
        }

        if (!$processo->data_primeira_retirada) {
            $processo->update([
                'data_primeira_retirada' => now()->toDateString(),
                'validade_apac'          => now()->addMonths(6)->toDateString(),
                'status'                 => 'em_andamento',
            ]);
        }

        $recibo = Recibo::create([
            'numero'                    => Recibo::gerarNumero(),
            'processo_id'               => $processo->id,
            'medicamento_id'            => $request->medicamento_id,
            'lote_id'                   => $request->lote_id,
            'mes_referencia'            => $request->mes_referencia,
            'quantidade'                => $request->quantidade,
            'data_emissao'              => now()->toDateString(),
            'validade_apac'             => $processo->fresh()->validade_apac?->toDateString(),
            'retirado_por_representante'=> $request->boolean('retirado_por_representante'),
            'representante_id'          => $request->boolean('retirado_por_representante') ? $request->representante_id : null,
            'observacoes'               => $request->observacoes,
            'gerado_por'                => auth()->id(),
        ]);

        return redirect()->route('recibos.imprimir', $recibo)
            ->with('success', 'Recibo gerado. Imprima e solicite a assinatura do paciente/representante.');
    }

    public function show(Recibo $recibo)
    {
        $recibo->load([
            'processo.paciente.representantes',
            'processo.cid10',
            'processo.medicoPrescritor',
            'medicamento',
            'lote',
            'representante',
            'geradoPor',
        ]);
        return view('recibos.show', compact('recibo'));
    }

    public function imprimir(Recibo $recibo)
    {
        $recibo->load([
            'processo.paciente.representantes',
            'processo.cid10',
            'processo.medicoPrescritor',
            'medicamento',
            'lote',
            'representante',
            'geradoPor',
        ]);
        return view('recibos.imprimir', compact('recibo'));
    }

    public function destroy(Recibo $recibo)
    {
        if ($recibo->lote_id) {
            $recibo->lote->increment('quantidade_atual', $recibo->quantidade);
        }
        $recibo->delete();
        return redirect()->route('recibos.index')->with('success', 'Recibo estornado.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class LoteController extends Controller
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
        $query = $this->escopoFarmacia(Lote::with('medicamento'));
        if ($request->filled('medicamento_id')) {
            $query->where('medicamento_id', $request->medicamento_id);
        }
        if ($request->filled('vencidos')) {
            $query->where('validade', '<', now());
        }
        $lotes = $query->latest()->paginate(20)->withQueryString();
        $medicamentos = Medicamento::ativo()->orderBy('nome')->get();
        return view('lotes.index', compact('lotes', 'medicamentos'));
    }

    public function create()
    {
        $medicamentos = Medicamento::ativo()->orderBy('nome')->get();
        return view('lotes.create', compact('medicamentos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medicamento_id'    => 'required|exists:medicamentos,id',
            'lote'              => 'required|string|max:50',
            'validade'          => 'required|date|after:today',
            'quantidade_inicial'=> 'required|integer|min:1',
            'data_entrada'      => 'required|date',
            'observacoes'       => 'nullable|string',
        ]);

        $data['quantidade_atual'] = $data['quantidade_inicial'];
        $data['farmacia_id'] = auth()->user()->farmacia_id;
        Lote::create($data);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote cadastrado com sucesso.');
    }

    public function show(Lote $lote)
    {
        $lote->load('medicamento', 'recibos.processo.paciente');
        return view('lotes.show', compact('lote'));
    }

    public function edit(Lote $lote)
    {
        $medicamentos = Medicamento::ativo()->orderBy('nome')->get();
        return view('lotes.edit', compact('lote', 'medicamentos'));
    }

    public function update(Request $request, Lote $lote)
    {
        $data = $request->validate([
            'lote'          => 'required|string|max:50',
            'validade'      => 'required|date',
            'observacoes'   => 'nullable|string',
        ]);

        $lote->update($data);
        return redirect()->route('lotes.index')
            ->with('success', 'Lote atualizado.');
    }

    public function destroy(Lote $lote)
    {
        if ($lote->recibos()->exists()) {
            return back()->with('error', 'Lote possui dispensações registradas e não pode ser removido.');
        }
        $lote->delete();
        return back()->with('success', 'Lote removido.');
    }
}

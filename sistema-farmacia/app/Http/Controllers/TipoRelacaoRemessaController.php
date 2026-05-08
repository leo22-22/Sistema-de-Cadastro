<?php

namespace App\Http\Controllers;

use App\Models\TipoRelacaoRemessa;
use Illuminate\Http\Request;

class TipoRelacaoRemessaController extends Controller
{
    public function index()
    {
        $tipos = TipoRelacaoRemessa::orderBy('nome')->paginate(15);
        return view('tipos-relacao-remessa.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos-relacao-remessa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
        ]);

        TipoRelacaoRemessa::create($request->all());

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo de relação/remessa cadastrado com sucesso.');
    }

    public function edit(TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        return view('tipos-relacao-remessa.edit', ['tipo' => $tipos_relacao_remessa]);
    }

    public function update(Request $request, TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'ativo'     => ['boolean'],
        ]);

        $tipos_relacao_remessa->update(array_merge($request->except('ativo'), [
            'ativo' => $request->boolean('ativo', true),
        ]));

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo de relação/remessa atualizado com sucesso.');
    }

    public function destroy(TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        if ($tipos_relacao_remessa->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um tipo vinculado a processos.');
        }

        $tipos_relacao_remessa->delete();

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo removido com sucesso.');
    }
}

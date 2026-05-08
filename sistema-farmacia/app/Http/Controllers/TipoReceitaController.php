<?php

namespace App\Http\Controllers;

use App\Models\TipoReceita;
use Illuminate\Http\Request;

class TipoReceitaController extends Controller
{
    public function index()
    {
        $tipos = TipoReceita::orderBy('nome')->paginate(15);
        return view('tipos-receita.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos-receita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'             => ['required', 'string', 'max:255'],
            'descricao'        => ['nullable', 'string'],
            'cor'              => ['required', 'string', 'in:primary,secondary,success,danger,warning,info,dark'],
            'requer_retencao'  => ['boolean'],
        ]);

        TipoReceita::create(array_merge($request->except('requer_retencao'), [
            'requer_retencao' => $request->boolean('requer_retencao'),
        ]));

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita cadastrado com sucesso.');
    }

    public function edit(TipoReceita $tipos_receita)
    {
        return view('tipos-receita.edit', ['tipo' => $tipos_receita]);
    }

    public function update(Request $request, TipoReceita $tipos_receita)
    {
        $request->validate([
            'nome'            => ['required', 'string', 'max:255'],
            'descricao'       => ['nullable', 'string'],
            'cor'             => ['required', 'string', 'in:primary,secondary,success,danger,warning,info,dark'],
            'requer_retencao' => ['boolean'],
            'ativo'           => ['boolean'],
        ]);

        $tipos_receita->update(array_merge($request->except(['requer_retencao', 'ativo']), [
            'requer_retencao' => $request->boolean('requer_retencao'),
            'ativo'           => $request->boolean('ativo', true),
        ]));

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita atualizado com sucesso.');
    }

    public function destroy(TipoReceita $tipos_receita)
    {
        if ($tipos_receita->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um tipo de receita vinculado a processos.');
        }

        $tipos_receita->delete();

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita removido com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TipoReceita;
use Illuminate\Http\Request;

class TipoReceitaController extends Controller
{
    private function escopoFarmacia($query)
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            $query->where('farmacia_id', $user->farmacia_id);
        }
        return $query;
    }

    private function autorizarGerenciar(): void
    {
        abort_unless(auth()->user()->isAdminFarmacia(), 403);
    }

    private function autorizarTipo(TipoReceita $tipo): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            abort_if($tipo->farmacia_id !== $user->farmacia_id, 403);
        }
    }

    public function index()
    {
        $tipos = $this->escopoFarmacia(TipoReceita::query())->orderBy('nome')->paginate(15);
        return view('tipos-receita.index', compact('tipos'));
    }

    public function create()
    {
        $this->autorizarGerenciar();
        return view('tipos-receita.create');
    }

    public function store(Request $request)
    {
        $this->autorizarGerenciar();

        $data = $request->validate([
            'nome'             => ['nullable', 'string', 'max:255'],
            'descricao'        => ['nullable', 'string'],
            'cor'              => ['nullable', 'string', 'in:primary,secondary,success,danger,warning,info,dark'],
            'requer_retencao'  => ['boolean'],
        ]);

        TipoReceita::create(array_merge($data, [
            'farmacia_id'     => auth()->user()->farmacia_id,
            'requer_retencao' => $request->boolean('requer_retencao'),
        ]));

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita cadastrado com sucesso.');
    }

    public function edit(TipoReceita $tipos_receita)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_receita);
        return view('tipos-receita.edit', ['tipo' => $tipos_receita]);
    }

    public function update(Request $request, TipoReceita $tipos_receita)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_receita);

        $data = $request->validate([
            'nome'            => ['nullable', 'string', 'max:255'],
            'descricao'       => ['nullable', 'string'],
            'cor'             => ['nullable', 'string', 'in:primary,secondary,success,danger,warning,info,dark'],
            'requer_retencao' => ['boolean'],
            'ativo'           => ['boolean'],
        ]);

        $tipos_receita->update(array_merge($data, [
            'requer_retencao' => $request->boolean('requer_retencao'),
            'ativo'           => $request->boolean('ativo', true),
        ]));

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita atualizado com sucesso.');
    }

    public function destroy(TipoReceita $tipos_receita)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_receita);

        if ($tipos_receita->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um tipo de receita vinculado a processos.');
        }

        $tipos_receita->delete();

        return redirect()->route('tipos-receita.index')->with('success', 'Tipo de receita removido com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TipoRelacaoRemessa;
use Illuminate\Http\Request;

class TipoRelacaoRemessaController extends Controller
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

    private function autorizarTipo(TipoRelacaoRemessa $tipo): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            abort_if($tipo->farmacia_id !== $user->farmacia_id, 403);
        }
    }

    public function index()
    {
        $tipos = $this->escopoFarmacia(TipoRelacaoRemessa::query())->orderBy('nome')->paginate(15);
        return view('tipos-relacao-remessa.index', compact('tipos'));
    }

    public function create()
    {
        $this->autorizarGerenciar();
        return view('tipos-relacao-remessa.create');
    }

    public function store(Request $request)
    {
        $this->autorizarGerenciar();

        $data = $request->validate([
            'nome'      => ['nullable', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
        ]);

        TipoRelacaoRemessa::create([...$data, 'farmacia_id' => auth()->user()->farmacia_id]);

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo de relação/remessa cadastrado com sucesso.');
    }

    public function edit(TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_relacao_remessa);
        return view('tipos-relacao-remessa.edit', ['tipo' => $tipos_relacao_remessa]);
    }

    public function update(Request $request, TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_relacao_remessa);

        $data = $request->validate([
            'nome'      => ['nullable', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'ativo'     => ['boolean'],
        ]);

        $tipos_relacao_remessa->update(array_merge($data, [
            'ativo' => $request->boolean('ativo', true),
        ]));

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo de relação/remessa atualizado com sucesso.');
    }

    public function destroy(TipoRelacaoRemessa $tipos_relacao_remessa)
    {
        $this->autorizarGerenciar();
        $this->autorizarTipo($tipos_relacao_remessa);

        if ($tipos_relacao_remessa->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um tipo vinculado a processos.');
        }

        $tipos_relacao_remessa->delete();

        return redirect()->route('tipos-relacao-remessa.index')->with('success', 'Tipo removido com sucesso.');
    }
}

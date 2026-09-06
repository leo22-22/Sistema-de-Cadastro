<?php

namespace App\Http\Controllers;

use App\Models\Cid10;
use App\Models\Medicamento;
use App\Models\TipoReceita;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicamentoController extends Controller
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

    private function autorizarMedicamento(Medicamento $medicamento): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin()) {
            abort_if($medicamento->farmacia_id !== $user->farmacia_id, 403);
        }
    }

    public function index(Request $request)
    {
        $query = $this->escopoFarmacia(Medicamento::with('tipoReceita'));

        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->busca . '%')
                  ->orWhere('principio_ativo', 'like', '%' . $request->busca . '%');
            });
        }

        $medicamentos = $query->orderBy('nome')->paginate(15)->withQueryString();
        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        $this->autorizarGerenciar();

        $farmaciaId   = auth()->user()->farmacia_id;
        $tiposReceita = TipoReceita::ativo()->where('farmacia_id', $farmaciaId)->orderBy('nome')->get();
        $cids         = Cid10::ativo()->orderBy('codigo')->get();
        return view('medicamentos.create', compact('tiposReceita', 'cids'));
    }

    public function store(Request $request)
    {
        $this->autorizarGerenciar();

        $farmaciaId = auth()->user()->farmacia_id;

        $data = $request->validate([
            'nome'               => ['nullable', 'string', 'max:255'],
            'principio_ativo'    => ['nullable', 'string', 'max:255'],
            'dosagem'            => ['nullable', 'string', 'max:100'],
            'forma_farmaceutica' => ['nullable', 'in:' . implode(',', array_keys(Medicamento::$formasFarmaceuticas))],
            'periodicidade'      => ['nullable', 'in:mensal,bimestral,trimestral'],
            'quantidade_diaria'  => ['nullable', 'numeric', 'min:0.5'],
            'tipo_receita_id'    => ['nullable', Rule::exists('tipos_receita', 'id')->where('farmacia_id', $farmaciaId)],
            'descricao'          => ['nullable', 'string'],
            'cids'               => ['nullable', 'array'],
            'cids.*'             => ['exists:cid10,id'],
        ]);

        $medicamento = Medicamento::create([...$data, 'farmacia_id' => $farmaciaId, 'ativo' => true]);

        if (!empty($data['cids'])) {
            $medicamento->cids()->sync($data['cids']);
        }

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento cadastrado com sucesso.');
    }

    public function edit(Medicamento $medicamento)
    {
        $this->autorizarGerenciar();
        $this->autorizarMedicamento($medicamento);

        $medicamento->load('cids');
        $tiposReceita = TipoReceita::ativo()->where('farmacia_id', $medicamento->farmacia_id)->orderBy('nome')->get();
        $cids         = Cid10::ativo()->orderBy('codigo')->get();
        return view('medicamentos.edit', compact('medicamento', 'tiposReceita', 'cids'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $this->autorizarGerenciar();
        $this->autorizarMedicamento($medicamento);

        $data = $request->validate([
            'nome'               => ['nullable', 'string', 'max:255'],
            'principio_ativo'    => ['nullable', 'string', 'max:255'],
            'dosagem'            => ['nullable', 'string', 'max:100'],
            'forma_farmaceutica' => ['nullable', 'in:' . implode(',', array_keys(Medicamento::$formasFarmaceuticas))],
            'periodicidade'      => ['nullable', 'in:mensal,bimestral,trimestral'],
            'quantidade_diaria'  => ['nullable', 'numeric', 'min:0.5'],
            'tipo_receita_id'    => ['nullable', Rule::exists('tipos_receita', 'id')->where('farmacia_id', $medicamento->farmacia_id)],
            'descricao'          => ['nullable', 'string'],
            'ativo'              => ['boolean'],
            'cids'               => ['nullable', 'array'],
            'cids.*'             => ['exists:cid10,id'],
        ]);

        $medicamento->update(array_merge($data, ['ativo' => $request->boolean('ativo')]));
        $medicamento->cids()->sync($data['cids'] ?? []);

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento atualizado com sucesso.');
    }

    public function destroy(Medicamento $medicamento)
    {
        $this->autorizarGerenciar();
        $this->autorizarMedicamento($medicamento);

        if ($medicamento->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um medicamento vinculado a processos.');
        }

        $medicamento->cids()->detach();
        $medicamento->delete();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento removido com sucesso.');
    }

    public function show(Medicamento $medicamento)
    {
        return redirect()->route('medicamentos.index');
    }
}

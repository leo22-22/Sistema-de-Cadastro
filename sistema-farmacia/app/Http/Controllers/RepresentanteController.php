<?php

namespace App\Http\Controllers;

use App\Models\Representante;
use Illuminate\Http\Request;

class RepresentanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Representante::query();

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%')
                  ->orWhere('cpf', 'like', '%' . $request->busca . '%');
        }

        $representantes = $query->orderBy('nome')->paginate(15)->withQueryString();

        return view('representantes.index', compact('representantes'));
    }

    public function create()
    {
        return view('representantes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'            => ['required', 'string', 'max:255'],
            'cpf'             => ['nullable', 'string', 'max:14', 'unique:representantes,cpf'],
            'rg'              => ['nullable', 'string', 'max:20'],
            'telefone'        => ['nullable', 'string', 'max:20'],
            'logradouro'      => ['nullable', 'string', 'max:255'],
            'numero_endereco' => ['nullable', 'string', 'max:20'],
            'complemento'     => ['nullable', 'string', 'max:100'],
            'bairro'          => ['nullable', 'string', 'max:100'],
            'cidade'          => ['nullable', 'string', 'max:100'],
            'uf'              => ['nullable', 'string', 'max:2'],
            'cep'             => ['nullable', 'string', 'max:9'],
            'observacoes'     => ['nullable', 'string'],
        ]);

        $representante = Representante::create(array_merge($data, ['ativo' => true]));

        return redirect()->route('representantes.show', $representante)->with('success', 'Representante cadastrado com sucesso.');
    }

    public function show(Representante $representante)
    {
        $representante->load('pacientes');
        return view('representantes.show', compact('representante'));
    }

    public function edit(Representante $representante)
    {
        return view('representantes.edit', compact('representante'));
    }

    public function update(Request $request, Representante $representante)
    {
        $data = $request->validate([
            'nome'            => ['required', 'string', 'max:255'],
            'cpf'             => ['nullable', 'string', 'max:14', 'unique:representantes,cpf,' . $representante->id],
            'rg'              => ['nullable', 'string', 'max:20'],
            'telefone'        => ['nullable', 'string', 'max:20'],
            'logradouro'      => ['nullable', 'string', 'max:255'],
            'numero_endereco' => ['nullable', 'string', 'max:20'],
            'complemento'     => ['nullable', 'string', 'max:100'],
            'bairro'          => ['nullable', 'string', 'max:100'],
            'cidade'          => ['nullable', 'string', 'max:100'],
            'uf'              => ['nullable', 'string', 'max:2'],
            'cep'             => ['nullable', 'string', 'max:9'],
            'observacoes'     => ['nullable', 'string'],
            'ativo'           => ['boolean'],
        ]);

        $representante->update(array_merge($data, ['ativo' => $request->boolean('ativo')]));

        return redirect()->route('representantes.show', $representante)->with('success', 'Representante atualizado com sucesso.');
    }

    public function destroy(Representante $representante)
    {
        if ($representante->recibos()->exists()) {
            return back()->with('error', 'Não é possível excluir um representante com recibos registrados.');
        }

        $representante->pacientes()->detach();
        $representante->delete();

        return redirect()->route('representantes.index')->with('success', 'Representante removido com sucesso.');
    }
}

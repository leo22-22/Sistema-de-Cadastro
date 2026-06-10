<?php

namespace App\Http\Controllers;

use App\Models\Farmacia;
use Illuminate\Http\Request;

class FarmaciaController extends Controller
{
    public function index()
    {
        $farmacias = Farmacia::withCount('users')->orderBy('nome')->paginate(20);
        return view('farmacias.index', compact('farmacias'));
    }

    public function create()
    {
        return view('farmacias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'        => ['required', 'string', 'max:255'],
            'cnpj'        => ['nullable', 'string', 'max:18', 'unique:farmacias,cnpj', 'cnpj'],
            'cnes'        => ['nullable', 'string', 'max:10'],
            'responsavel' => ['nullable', 'string', 'max:255'],
            'endereco'    => ['nullable', 'string', 'max:255'],
            'cidade'      => ['nullable', 'string', 'max:100'],
            'estado'      => ['nullable', 'string', 'size:2'],
            'telefone'    => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
        ]);

        Farmacia::create([...$request->only([
            'nome', 'cnpj', 'cnes', 'responsavel',
            'endereco', 'cidade', 'estado', 'telefone', 'email',
        ]), 'ativo' => true]);

        return redirect()->route('farmacias.index')->with('success', 'Farmácia cadastrada com sucesso.');
    }

    public function edit(Farmacia $farmacia)
    {
        $farmacia->load('users');
        return view('farmacias.edit', compact('farmacia'));
    }

    public function update(Request $request, Farmacia $farmacia)
    {
        $request->validate([
            'nome'        => ['required', 'string', 'max:255'],
            'cnpj'        => ['nullable', 'string', 'max:18', 'unique:farmacias,cnpj,' . $farmacia->id, 'cnpj'],
            'cnes'        => ['nullable', 'string', 'max:10'],
            'responsavel' => ['nullable', 'string', 'max:255'],
            'endereco'    => ['nullable', 'string', 'max:255'],
            'cidade'      => ['nullable', 'string', 'max:100'],
            'estado'      => ['nullable', 'string', 'size:2'],
            'telefone'    => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
            'ativo'       => ['boolean'],
        ]);

        $farmacia->update([...$request->only([
            'nome', 'cnpj', 'cnes', 'responsavel',
            'endereco', 'cidade', 'estado', 'telefone', 'email',
        ]), 'ativo' => $request->boolean('ativo')]);

        return redirect()->route('farmacias.index')->with('success', 'Farmácia atualizada com sucesso.');
    }

    public function destroy(Farmacia $farmacia)
    {
        if ($farmacia->users()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma farmácia com usuários vinculados.');
        }

        $farmacia->delete();
        return redirect()->route('farmacias.index')->with('success', 'Farmácia removida com sucesso.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nome'            => ['nullable', 'string', 'max:255'],
            'cpf'             => ['nullable', 'string', 'max:14', 'cpf'],
            'rg'              => ['nullable', 'string', 'max:20'],
            'telefone'        => ['nullable', 'string', 'max:20'],
            'logradouro'      => ['nullable', 'string', 'max:255'],
            'numero_endereco' => ['nullable', 'string', 'max:20'],
            'complemento'     => ['nullable', 'string', 'max:100'],
            'bairro'          => ['nullable', 'string', 'max:100'],
            'cidade'          => ['nullable', 'string', 'max:100'],
            'uf'              => ['nullable', 'string', 'size:2'],
            'cep'             => ['nullable', 'string', 'max:10'],
            'observacoes'     => ['nullable', 'string'],
        ], [
            'cpf.cpf' => 'CPF inválido. Verifique os dígitos e tente novamente.',
        ]);

        $validator->after(function ($v) use ($request) {
            $cpf = $request->input('cpf');
            $rg  = $request->input('rg');

            if ($cpf && !$v->errors()->has('cpf')) {
                $dupRep = Representante::withTrashed()->where('cpf', $cpf)->first();
                if ($dupRep) {
                    $sufixo = $dupRep->trashed() ? ' (registro inativo)' : '';
                    $v->errors()->add('cpf', "Este CPF já está cadastrado como Representante: {$dupRep->nome}{$sufixo}.");
                } else {
                    $dupPac = Paciente::where('cpf', $cpf)->first();
                    if ($dupPac) {
                        $v->errors()->add('cpf', "Este CPF já está cadastrado como Paciente: {$dupPac->nome}. Verifique se não é um cadastro duplicado.");
                    }
                }
            }

            if ($rg && !$v->errors()->has('rg')) {
                $dupRgRep = Representante::withTrashed()->where('rg', $rg)->first();
                if ($dupRgRep) {
                    $sufixo = $dupRgRep->trashed() ? ' (registro inativo)' : '';
                    $v->errors()->add('rg', "Este RG já está cadastrado como Representante: {$dupRgRep->nome}{$sufixo}.");
                } else {
                    $dupRgPac = Paciente::where('rg', $rg)->first();
                    if ($dupRgPac) {
                        $v->errors()->add('rg', "Este RG já está cadastrado como Paciente: {$dupRgPac->nome}.");
                    }
                }
            }
        });

        $data = $validator->validate();

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
        $validator = Validator::make($request->all(), [
            'nome'            => ['nullable', 'string', 'max:255'],
            'cpf'             => ['nullable', 'string', 'max:14', 'cpf'],
            'rg'              => ['nullable', 'string', 'max:20'],
            'telefone'        => ['nullable', 'string', 'max:20'],
            'logradouro'      => ['nullable', 'string', 'max:255'],
            'numero_endereco' => ['nullable', 'string', 'max:20'],
            'complemento'     => ['nullable', 'string', 'max:100'],
            'bairro'          => ['nullable', 'string', 'max:100'],
            'cidade'          => ['nullable', 'string', 'max:100'],
            'uf'              => ['nullable', 'string', 'size:2'],
            'cep'             => ['nullable', 'string', 'max:10'],
            'observacoes'     => ['nullable', 'string'],
            'ativo'           => ['boolean'],
        ], [
            'cpf.cpf' => 'CPF inválido. Verifique os dígitos e tente novamente.',
        ]);

        $validator->after(function ($v) use ($request, $representante) {
            $cpf = $request->input('cpf');
            $rg  = $request->input('rg');

            if ($cpf && !$v->errors()->has('cpf')) {
                $dupRep = Representante::withTrashed()->where('cpf', $cpf)->where('id', '!=', $representante->id)->first();
                if ($dupRep) {
                    $sufixo = $dupRep->trashed() ? ' (registro inativo)' : '';
                    $v->errors()->add('cpf', "Este CPF já está cadastrado como Representante: {$dupRep->nome}{$sufixo}.");
                } else {
                    $dupPac = Paciente::where('cpf', $cpf)->first();
                    if ($dupPac) {
                        $v->errors()->add('cpf', "Este CPF já está cadastrado como Paciente: {$dupPac->nome}. Verifique se não é um cadastro duplicado.");
                    }
                }
            }

            if ($rg && !$v->errors()->has('rg')) {
                $dupRgRep = Representante::withTrashed()->where('rg', $rg)->where('id', '!=', $representante->id)->first();
                if ($dupRgRep) {
                    $sufixo = $dupRgRep->trashed() ? ' (registro inativo)' : '';
                    $v->errors()->add('rg', "Este RG já está cadastrado como Representante: {$dupRgRep->nome}{$sufixo}.");
                } else {
                    $dupRgPac = Paciente::where('rg', $rg)->first();
                    if ($dupRgPac) {
                        $v->errors()->add('rg', "Este RG já está cadastrado como Paciente: {$dupRgPac->nome}.");
                    }
                }
            }
        });

        $data = $validator->validate();

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

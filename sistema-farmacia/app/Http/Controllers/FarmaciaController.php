<?php

namespace App\Http\Controllers;

use App\Mail\CredenciaisFarmaciaMail;
use App\Models\Farmacia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'email_admin' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nome_admin'  => ['required', 'string', 'max:255'],
        ]);

        $farmacia = Farmacia::create([...$request->only([
            'nome', 'cnpj', 'cnes', 'responsavel',
            'endereco', 'cidade', 'estado', 'telefone', 'email',
        ]), 'ativo' => true]);

        // Gera senha aleatória e cria o usuário admin_farmacia
        $senha = Str::password(12, true, true, false);

        User::create([
            'name'       => $request->nome_admin,
            'email'      => $request->email_admin,
            'password'   => bcrypt($senha),
            'role'       => 'admin_farmacia',
            'active'     => true,
            'farmacia_id'=> $farmacia->id,
        ]);

        // Envia as credenciais por e-mail
        try {
            Mail::to($request->email_admin)->send(new CredenciaisFarmaciaMail(
                farmacia:   $farmacia,
                emailAdmin: $request->email_admin,
                nomeAdmin:  $request->nome_admin,
                senha:      $senha,
                urlSistema: config('app.url'),
            ));
            $emailMsg = "Credenciais enviadas para {$request->email_admin}.";
        } catch (\Exception $e) {
            // Não falha o cadastro se o email não sair
            $emailMsg = "Farmácia cadastrada, mas o e-mail não pôde ser enviado. Senha gerada: <strong>{$senha}</strong>";
        }

        return redirect()->route('farmacias.index')
            ->with('success', "Farmácia cadastrada com sucesso. {$emailMsg}");
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

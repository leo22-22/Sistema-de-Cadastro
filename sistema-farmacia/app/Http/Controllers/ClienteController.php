<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Exibe o formulário de cadastro
    public function create()
    {
        return view('clientes.create');
    }

    // Recebe os dados e salva no banco
    public function store(Request $request)
    {
        // Validação básica para garantir integridade
        $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'documento'     => 'required|unique:clientes,documento',
            'tipo'          => 'required|in:PF,PJ',
        ]);

        // Criação do registro no banco
        Cliente::create($request->all());

        // Redireciona para a home com uma mensagem de sucesso
        return redirect()->route('home')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function index()
    {
        // Pega todos os clientes do banco, ordenados pelo mais recente
        $clientes = Cliente::orderBy('created_at', 'desc')->get();
        
        return view('clientes.index', compact('clientes'));
    }

    // Função para eliminar um cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente::destroy($id);

        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => ['nullable', 'string', 'max:255'],
            'email'     => ['nullable', 'email', 'max:255'],
            'telefone'  => ['nullable', 'string', 'max:20'],
            'municipio' => ['nullable', 'string', 'max:255'],
            'estado'    => ['nullable', 'string', 'size:2'],
            'mensagem'  => ['nullable', 'string', 'max:1000'],
        ]);

        ContactRequest::create($request->only('nome', 'email', 'telefone', 'municipio', 'estado', 'mensagem'));

        return back()->with('contato_enviado', true);
    }

    public function index()
    {
        $solicitacoes = ContactRequest::latest()->paginate(20);
        return view('superadmin.solicitacoes', compact('solicitacoes'));
    }

    public function marcarLido(ContactRequest $contactRequest)
    {
        $contactRequest->update(['lido' => true]);
        return back()->with('success', 'Solicitação marcada como lida.');
    }
}

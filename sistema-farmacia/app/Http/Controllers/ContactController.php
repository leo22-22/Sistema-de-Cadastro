<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'telefone'  => ['required', 'string', 'max:20'],
            'municipio' => ['required', 'string', 'max:255'],
            'estado'    => ['required', 'string', 'size:2'],
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

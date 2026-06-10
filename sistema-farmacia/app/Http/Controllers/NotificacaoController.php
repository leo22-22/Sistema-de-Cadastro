<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function marcarLida(string $id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return back();
    }

    public function marcarTodasLidas()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Todas as notificações marcadas como lidas.');
    }

    public function index()
    {
        $notificacoes = auth()->user()->notifications()->latest()->paginate(30);
        return view('notificacoes.index', compact('notificacoes'));
    }
}

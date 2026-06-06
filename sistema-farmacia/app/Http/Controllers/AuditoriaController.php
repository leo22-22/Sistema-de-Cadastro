<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = ActivityLog::with('usuario', 'farmacia')->latest();

        if (!$user->isSuperadmin() && $user->farmacia_id) {
            $query->where('farmacia_id', $user->farmacia_id);
        }

        if ($request->filled('acao')) {
            $query->where('acao', $request->acao);
        }

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        if ($request->filled('data_de')) {
            $query->whereDate('created_at', '>=', $request->data_de);
        }

        if ($request->filled('data_ate')) {
            $query->whereDate('created_at', '<=', $request->data_ate);
        }

        $logs    = $query->paginate(30)->withQueryString();
        $acoes   = ActivityLog::select('acao')->distinct()->pluck('acao');

        return view('auditoria.index', compact('logs', 'acoes'));
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminFarmacia
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || (!$user->isSuperadmin() && !$user->isAdminFarmacia())) {
            abort(403, 'Acesso restrito a administradores de farmácia.');
        }

        return $next($request);
    }
}

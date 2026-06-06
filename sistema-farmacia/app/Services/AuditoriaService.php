<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class AuditoriaService
{
    public static function log(
        string $acao,
        string $descricao,
        ?string $modelo = null,
        ?int $modeloId = null,
        ?array $dadosAnteriores = null,
        ?array $dadosNovos = null
    ): void {
        $user = auth()->user();

        ActivityLog::create([
            'user_id'          => $user?->id,
            'farmacia_id'      => $user?->farmacia_id,
            'acao'             => $acao,
            'modelo'           => $modelo,
            'modelo_id'        => $modeloId,
            'descricao'        => $descricao,
            'dados_anteriores' => $dadosAnteriores,
            'dados_novos'      => $dadosNovos,
            'ip'               => Request::ip(),
        ]);
    }
}

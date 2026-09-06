<?php

namespace App\Services;

use App\Models\Medicamento;
use App\Models\TipoReceita;
use App\Models\TipoRelacaoRemessa;
use Illuminate\Support\Facades\DB;

class CatalogoFarmaciaService
{
    /**
     * Copia o catálogo padrão (linhas "modelo", com farmacia_id NULL) de
     * Medicamentos, Tipos de Receita e Tipos de Relação/Remessa para uma
     * farmácia — usado ao criar uma farmácia nova. Cada farmácia gerencia
     * sua própria cópia dali em diante, sem afetar as demais.
     */
    public static function seedParaFarmacia(int $farmaciaId): void
    {
        // Idempotente: não duplica se a farmácia já tem catálogo próprio (ex.: o
        // db:seed --force do docker-entrypoint.sh roda a cada deploy/restart).
        $jaTemCatalogo = Medicamento::where('farmacia_id', $farmaciaId)->exists()
            || TipoReceita::where('farmacia_id', $farmaciaId)->exists()
            || TipoRelacaoRemessa::where('farmacia_id', $farmaciaId)->exists();

        if ($jaTemCatalogo) {
            return;
        }

        DB::transaction(function () use ($farmaciaId) {
            $mapaTipoReceita = [];
            foreach (TipoReceita::whereNull('farmacia_id')->get() as $tipo) {
                $novo = TipoReceita::create([
                    'farmacia_id'     => $farmaciaId,
                    'nome'            => $tipo->nome,
                    'descricao'       => $tipo->descricao,
                    'cor'             => $tipo->cor,
                    'requer_retencao' => $tipo->requer_retencao,
                    'ativo'           => $tipo->ativo,
                ]);
                $mapaTipoReceita[$tipo->id] = $novo->id;
            }

            foreach (TipoRelacaoRemessa::whereNull('farmacia_id')->get() as $tipo) {
                TipoRelacaoRemessa::create([
                    'farmacia_id' => $farmaciaId,
                    'nome'        => $tipo->nome,
                    'descricao'   => $tipo->descricao,
                    'ativo'       => $tipo->ativo,
                ]);
            }

            foreach (Medicamento::whereNull('farmacia_id')->with('cids')->get() as $medicamento) {
                $novo = Medicamento::create([
                    'farmacia_id'        => $farmaciaId,
                    'nome'               => $medicamento->nome,
                    'principio_ativo'    => $medicamento->principio_ativo,
                    'dosagem'            => $medicamento->dosagem,
                    'forma_farmaceutica' => $medicamento->forma_farmaceutica,
                    'periodicidade'      => $medicamento->periodicidade,
                    'quantidade_diaria'  => $medicamento->quantidade_diaria,
                    'tipo_receita_id'    => $medicamento->tipo_receita_id
                        ? ($mapaTipoReceita[$medicamento->tipo_receita_id] ?? null)
                        : null,
                    'descricao' => $medicamento->descricao,
                    'ativo'     => $medicamento->ativo,
                ]);

                if ($medicamento->cids->isNotEmpty()) {
                    $novo->cids()->sync($medicamento->cids->pluck('id'));
                }
            }
        });
    }
}

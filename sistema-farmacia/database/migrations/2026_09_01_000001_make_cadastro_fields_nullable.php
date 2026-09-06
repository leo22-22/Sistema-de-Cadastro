<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Colunas (tabela, coluna, tipo MySQL) que deixam de ser NOT NULL para
     * permitir salvar registros incompletos (o usuário completa os dados depois).
     */
    private array $colunas = [
        ['pacientes', 'nome', 'VARCHAR(255)'],
        ['representantes', 'nome', 'VARCHAR(255)'],
        ['medicos_prescritores', 'nome', 'VARCHAR(255)'],
        ['medicamentos', 'nome', 'VARCHAR(255)'],
        ['tipos_receita', 'nome', 'VARCHAR(255)'],
        ['tipos_receita', 'cor', "VARCHAR(255) DEFAULT 'secondary'"],
        ['tipos_relacao_remessa', 'nome', 'VARCHAR(255)'],
        ['lotes', 'medicamento_id', 'BIGINT UNSIGNED'],
        ['lotes', 'lote', 'VARCHAR(255)'],
        ['lotes', 'validade', 'DATE'],
        ['lotes', 'data_entrada', 'DATE'],
        ['paciente_alergias', 'descricao', 'VARCHAR(255)'],
        ['processos', 'paciente_id', 'BIGINT UNSIGNED'],
        ['processos', 'cid10_id', 'BIGINT UNSIGNED'],
        ['contact_requests', 'nome', 'VARCHAR(255)'],
        ['contact_requests', 'email', 'VARCHAR(255)'],
        ['contact_requests', 'telefone', 'VARCHAR(20)'],
        ['contact_requests', 'municipio', 'VARCHAR(255)'],
        ['contact_requests', 'estado', 'VARCHAR(2)'],
    ];

    public function up(): void
    {
        foreach ($this->colunas as [$tabela, $coluna, $tipoMysql]) {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement("ALTER TABLE {$tabela} ALTER COLUMN {$coluna} DROP NOT NULL");
            } else {
                DB::statement("ALTER TABLE {$tabela} MODIFY {$coluna} {$tipoMysql} NULL");
            }
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->colunas) as [$tabela, $coluna, $tipoMysql]) {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement("ALTER TABLE {$tabela} ALTER COLUMN {$coluna} SET NOT NULL");
            } else {
                DB::statement("ALTER TABLE {$tabela} MODIFY {$coluna} {$tipoMysql} NOT NULL");
            }
        }
    }
};

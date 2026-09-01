<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Relaxa colunas NOT NULL de formulários de cadastro para permitir salvar
     * registros incompletos (o usuário completa os dados depois).
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE pacientes MODIFY nome VARCHAR(255) NULL');
        DB::statement('ALTER TABLE representantes MODIFY nome VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medicos_prescritores MODIFY nome VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medicamentos MODIFY nome VARCHAR(255) NULL');
        DB::statement("ALTER TABLE tipos_receita MODIFY nome VARCHAR(255) NULL");
        DB::statement("ALTER TABLE tipos_receita MODIFY cor VARCHAR(255) NULL DEFAULT 'secondary'");
        DB::statement('ALTER TABLE tipos_relacao_remessa MODIFY nome VARCHAR(255) NULL');
        DB::statement('ALTER TABLE lotes MODIFY medicamento_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE lotes MODIFY lote VARCHAR(255) NULL');
        DB::statement('ALTER TABLE lotes MODIFY validade DATE NULL');
        DB::statement('ALTER TABLE lotes MODIFY data_entrada DATE NULL');
        DB::statement('ALTER TABLE paciente_alergias MODIFY descricao VARCHAR(255) NULL');
        DB::statement('ALTER TABLE processos MODIFY paciente_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE processos MODIFY cid10_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY nome VARCHAR(255) NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY email VARCHAR(255) NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY telefone VARCHAR(20) NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY municipio VARCHAR(255) NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY estado VARCHAR(2) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE contact_requests MODIFY estado VARCHAR(2) NOT NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY municipio VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY telefone VARCHAR(20) NOT NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY email VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE contact_requests MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE processos MODIFY cid10_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE processos MODIFY paciente_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE paciente_alergias MODIFY descricao VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE lotes MODIFY data_entrada DATE NOT NULL');
        DB::statement('ALTER TABLE lotes MODIFY validade DATE NOT NULL');
        DB::statement('ALTER TABLE lotes MODIFY lote VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE lotes MODIFY medicamento_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE tipos_relacao_remessa MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement("ALTER TABLE tipos_receita MODIFY cor VARCHAR(255) NOT NULL DEFAULT 'secondary'");
        DB::statement('ALTER TABLE tipos_receita MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medicamentos MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE medicos_prescritores MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE representantes MODIFY nome VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE pacientes MODIFY nome VARCHAR(255) NOT NULL');
    }
};

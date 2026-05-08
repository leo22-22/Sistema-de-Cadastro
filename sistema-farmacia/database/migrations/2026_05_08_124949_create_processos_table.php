<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->enum('tipo_processo', ['abertura','retratado','transferencia','renovacao','continuidade'])->default('abertura');
            $table->foreignId('paciente_id')->constrained()->onDelete('restrict');
            $table->foreignId('cid10_id')->constrained('cid10')->onDelete('restrict');
            $table->foreignId('medico_prescritor_id')->nullable()->constrained('medicos_prescritores')->onDelete('set null');
            $table->foreignId('tipo_receita_id')->nullable()->constrained('tipos_receita')->onDelete('set null');
            $table->foreignId('tipo_relacao_remessa_id')->nullable()->constrained('tipos_relacao_remessa')->onDelete('set null');
            $table->string('numero_receita')->nullable();
            $table->date('data_receita')->nullable();
            $table->date('data_validade_receita')->nullable();
            $table->date('data_primeira_retirada')->nullable();
            $table->date('validade_apac')->nullable();
            $table->enum('status', ['aberto','em_andamento','concluido','cancelado'])->default('aberto');
            $table->boolean('lme_entregue')->default(false);
            $table->boolean('receita_entregue')->default(false);
            $table->boolean('exame_entregue')->default(false);
            $table->boolean('documentos_entregues')->default(false);
            $table->text('observacoes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};

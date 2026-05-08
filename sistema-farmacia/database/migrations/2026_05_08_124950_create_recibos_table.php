<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('processo_id')->constrained()->onDelete('restrict');
            $table->foreignId('medicamento_id')->constrained()->onDelete('restrict');
            $table->foreignId('lote_id')->nullable()->constrained('lotes')->onDelete('set null');
            $table->date('mes_referencia');
            $table->integer('quantidade');
            $table->date('data_emissao');
            $table->date('validade_apac')->nullable();
            $table->boolean('retirado_por_representante')->default(false);
            $table->foreignId('representante_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignId('gerado_por')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }
};

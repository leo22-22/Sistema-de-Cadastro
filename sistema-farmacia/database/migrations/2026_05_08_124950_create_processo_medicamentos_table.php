<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processo_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicamento_id')->constrained()->onDelete('restrict');
            $table->enum('periodicidade', ['mensal','bimestral','trimestral'])->default('mensal');
            $table->decimal('quantidade_diaria', 6, 2)->nullable();
            $table->integer('quantidade_mensal')->unsigned()->nullable();
            $table->string('posologia')->nullable();
            $table->string('observacoes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processo_medicamentos');
    }
};

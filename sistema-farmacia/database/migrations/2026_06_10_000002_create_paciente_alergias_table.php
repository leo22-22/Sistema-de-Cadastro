<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paciente_alergias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->enum('tipo', ['medicamento', 'substancia', 'alimento', 'outro'])->default('medicamento');
            $table->string('descricao');
            $table->enum('gravidade', ['leve', 'moderada', 'grave', 'nao_informada'])->default('nao_informada');
            $table->string('reacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente_alergias');
    }
};

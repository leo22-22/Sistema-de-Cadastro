<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paciente_representante', function (Blueprint $table) {
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade');
            $table->foreignId('representante_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('ordem')->default(1);
            $table->primary(['paciente_id', 'representante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente_representante');
    }
};

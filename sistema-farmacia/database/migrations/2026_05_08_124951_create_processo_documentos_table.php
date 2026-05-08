<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processo_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['lme','receita','exame','documento_pessoal','outro']);
            $table->string('nome_original');
            $table->string('arquivo');
            $table->unsignedBigInteger('tamanho')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->foreignId('enviado_por')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processo_documentos');
    }
};

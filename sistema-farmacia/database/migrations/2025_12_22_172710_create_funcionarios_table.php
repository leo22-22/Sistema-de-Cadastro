<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('funcionarios', function (Blueprint $table) {
        $table->id();
        $table->string('nome_completo');
        $table->string('cpf')->unique();
        $table->string('rg')->nullable();
        $table->string('cargo');
        $table->decimal('salario', 12, 2); // Suporta salários altos
        $table->decimal('bonificacao', 12, 2)->default(0);
        $table->date('data_admissao');
        $table->string('status')->default('Ativo'); // Ativo, Afastado, Desligado
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};

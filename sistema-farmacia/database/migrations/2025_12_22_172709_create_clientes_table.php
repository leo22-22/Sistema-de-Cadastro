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
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nome_fantasia'); // Para a lojinha ou barbearia
        $table->string('razao_social')->nullable(); // Para a empresa grande
        $table->enum('tipo', ['PF', 'PJ'])->default('PF');
        $table->string('documento')->unique(); // CPF ou CNPJ
        $table->string('telefone')->nullable();
        $table->string('email')->nullable();
        $table->text('observacoes')->nullable(); // Ex: "Prefere corte degradê" ou "Cliente VIP"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

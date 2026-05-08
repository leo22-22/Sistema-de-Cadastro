<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_mae')->nullable();
            $table->string('cpf', 14)->unique()->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('cns', 15)->unique()->nullable();
            $table->string('prontuario')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('raca_cor', ['branca','preta','parda','amarela','indigena','nao_informada'])->default('nao_informada');
            $table->decimal('peso', 5, 2)->nullable();
            $table->smallInteger('altura')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero_endereco', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('cep', 10)->nullable();
            $table->boolean('sem_representante')->default(false);
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};

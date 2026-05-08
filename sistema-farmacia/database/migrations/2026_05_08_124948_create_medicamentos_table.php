<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('principio_ativo')->nullable();
            $table->string('dosagem')->nullable();
            $table->enum('forma_farmaceutica', [
                'comprimido','capsula','xarope','solucao_oral','suspensao',
                'injetavel','creme','pomada','gel','gotas','spray',
                'supositorio','po','sache','adesivo','outros'
            ])->default('comprimido');
            $table->enum('periodicidade', ['mensal','bimestral','trimestral'])->default('mensal');
            $table->decimal('quantidade_diaria', 6, 2)->nullable();
            $table->unsignedBigInteger('tipo_receita_id')->nullable();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};

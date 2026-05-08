<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicamento_id')->constrained()->onDelete('restrict');
            $table->string('lote');
            $table->date('validade');
            $table->integer('quantidade_inicial')->unsigned()->default(0);
            $table->integer('quantidade_atual')->unsigned()->default(0);
            $table->date('data_entrada');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};

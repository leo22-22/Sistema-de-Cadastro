<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamento_cid', function (Blueprint $table) {
            $table->foreignId('medicamento_id')->constrained()->onDelete('cascade');
            $table->foreignId('cid10_id')->constrained('cid10')->onDelete('cascade');
            $table->primary(['medicamento_id', 'cid10_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamento_cid');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->foreignId('farmacia_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('farmacias')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['farmacia_id']);
            $table->dropColumn('farmacia_id');
        });
    }
};

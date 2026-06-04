<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('observacoes')
                  ->constrained('users')->nullOnDelete();
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('observacoes')
                  ->constrained('users')->nullOnDelete();
        });

        Schema::table('processos', function (Blueprint $table) {
            $table->foreignId('updated_by')->nullable()->after('created_by')
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('status_updated_at')->nullable()->after('updated_by');
        });
    }

    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
        Schema::table('processos', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['updated_by', 'status_updated_at']);
        });
    }
};

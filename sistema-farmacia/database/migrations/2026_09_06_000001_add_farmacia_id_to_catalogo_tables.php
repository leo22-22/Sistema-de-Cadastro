<?php

use App\Models\Farmacia;
use App\Services\CatalogoFarmaciaService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Medicamentos, Tipos de Receita e Tipos de Remessa deixam de ser um catálogo
     * global (gerido pelo superadmin) e passam a pertencer a cada farmácia. As
     * linhas com farmacia_id NULL continuam existindo como "modelo padrão" —
     * usadas só para copiar um catálogo inicial para farmácias novas ou já
     * existentes (CatalogoFarmaciaService::seedParaFarmacia).
     */
    public function up(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->foreignId('farmacia_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('tipos_receita', function (Blueprint $table) {
            $table->foreignId('farmacia_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('tipos_relacao_remessa', function (Blueprint $table) {
            $table->foreignId('farmacia_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        foreach (Farmacia::all() as $farmacia) {
            CatalogoFarmaciaService::seedParaFarmacia($farmacia->id);
        }
    }

    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('farmacia_id');
        });
        Schema::table('tipos_receita', function (Blueprint $table) {
            $table->dropConstrainedForeignId('farmacia_id');
        });
        Schema::table('tipos_relacao_remessa', function (Blueprint $table) {
            $table->dropConstrainedForeignId('farmacia_id');
        });
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'processo_id', 'medicamento_id', 'lote_id',
        'mes_referencia', 'quantidade', 'data_emissao',
        'validade_apac', 'retirado_por_representante', 'representante_id',
        'valor_total', 'observacoes', 'gerado_por',
    ];

    protected function casts(): array
    {
        return [
            'data_emissao'            => 'date',
            'mes_referencia'          => 'date',
            'validade_apac'           => 'date',
            'valor_total'             => 'decimal:2',
            'retirado_por_representante' => 'boolean',
        ];
    }

    public static function gerarNumero(): string
    {
        $ano = now()->year;
        $ultimo = static::whereYear('created_at', $ano)->count() + 1;
        return sprintf('REC-%d-%04d', $ano, $ultimo);
    }

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function representante()
    {
        return $this->belongsTo(Representante::class);
    }

    public function geradoPor()
    {
        return $this->belongsTo(User::class, 'gerado_por');
    }

    public function getMesReferenciaLabelAttribute(): string
    {
        return $this->mes_referencia?->translatedFormat('F \d\e Y') ?? '—';
    }
}

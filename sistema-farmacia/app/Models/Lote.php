<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmacia_id',
        'medicamento_id', 'lote', 'validade',
        'quantidade_inicial', 'quantidade_atual',
        'data_entrada', 'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'validade'     => 'date',
            'data_entrada' => 'date',
        ];
    }

    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class);
    }

    public function estaVencido(): bool
    {
        return $this->validade->isPast();
    }

    public function temEstoque(): bool
    {
        return $this->quantidade_atual > 0;
    }
}

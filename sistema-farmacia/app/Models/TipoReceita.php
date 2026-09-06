<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoReceita extends Model
{
    use HasFactory;

    protected $table = 'tipos_receita';

    protected $fillable = [
        'farmacia_id',
        'nome',
        'descricao',
        'cor',
        'requer_retencao',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'requer_retencao' => 'boolean',
            'ativo' => 'boolean',
        ];
    }

    public function processos()
    {
        return $this->hasMany(Processo::class);
    }

    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRelacaoRemessa extends Model
{
    use HasFactory;

    protected $table = 'tipos_relacao_remessa';

    protected $fillable = [
        'nome',
        'descricao',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function processos()
    {
        return $this->hasMany(Processo::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}

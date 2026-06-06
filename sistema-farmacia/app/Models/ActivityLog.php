<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'farmacia_id', 'acao', 'modelo', 'modelo_id',
        'descricao', 'dados_anteriores', 'dados_novos', 'ip',
    ];

    protected function casts(): array
    {
        return [
            'dados_anteriores' => 'array',
            'dados_novos'      => 'array',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class);
    }
}

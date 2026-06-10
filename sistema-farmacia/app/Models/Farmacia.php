<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farmacia extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome', 'cnpj', 'cnes', 'responsavel',
        'endereco', 'cidade', 'estado', 'telefone', 'email', 'ativo',
    ];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function processos()
    {
        return $this->hasMany(Processo::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}

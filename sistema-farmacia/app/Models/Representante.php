<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cpf', 'rg', 'telefone',
        'logradouro', 'numero_endereco', 'complemento',
        'bairro', 'cidade', 'uf', 'cep',
        'observacoes', 'ativo',
    ];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'paciente_representante')
            ->withPivot('ordem')
            ->orderByPivot('ordem');
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function getEnderecoCompletoAttribute(): string
    {
        $partes = array_filter([
            $this->logradouro,
            $this->numero_endereco ? 'nº ' . $this->numero_endereco : null,
            $this->complemento,
            $this->bairro,
            $this->cidade,
            $this->uf,
        ]);
        return implode(', ', $partes);
    }
}

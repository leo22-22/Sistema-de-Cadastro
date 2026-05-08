<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'nome_mae', 'cpf', 'rg', 'cns', 'prontuario',
        'data_nascimento', 'raca_cor', 'peso', 'altura',
        'telefone', 'email',
        'logradouro', 'numero_endereco', 'complemento', 'bairro',
        'cidade', 'uf', 'cep',
        'sem_representante', 'observacoes', 'ativo',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento'  => 'date',
            'ativo'            => 'boolean',
            'sem_representante'=> 'boolean',
        ];
    }

    public function representantes()
    {
        return $this->belongsToMany(Representante::class, 'paciente_representante')
            ->withPivot('ordem')
            ->orderByPivot('ordem');
    }

    public function processos()
    {
        return $this->hasMany(Processo::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function getIdadeAttribute(): ?int
    {
        return $this->data_nascimento?->age;
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

    public static array $racaCorLabels = [
        'branca'       => 'Branca',
        'preta'        => 'Preta',
        'parda'        => 'Parda',
        'amarela'      => 'Amarela',
        'indigena'     => 'Indígena',
        'nao_informada'=> 'Não Informada',
    ];
}

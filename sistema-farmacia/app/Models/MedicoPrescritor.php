<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoPrescritor extends Model
{
    use HasFactory;

    protected $table = 'medicos_prescritores';

    protected $fillable = [
        'nome', 'crm', 'cns', 'cnes', 'estabelecimento',
        'especialidade', 'telefone', 'cidade', 'uf', 'ativo',
    ];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
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

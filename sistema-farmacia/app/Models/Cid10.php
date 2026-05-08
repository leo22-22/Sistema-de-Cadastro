<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cid10 extends Model
{
    public $timestamps = false;
    protected $table = 'cid10';

    protected $fillable = ['codigo', 'nome', 'categoria', 'ativo'];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function processos()
    {
        return $this->hasMany(Processo::class);
    }

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'medicamento_cid', 'cid10_id', 'medicamento_id');
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function getLabelAttribute(): string
    {
        return "{$this->codigo} — {$this->nome}";
    }
}

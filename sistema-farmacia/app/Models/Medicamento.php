<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'principio_ativo', 'dosagem', 'forma_farmaceutica',
        'periodicidade', 'quantidade_diaria', 'tipo_receita_id',
        'descricao', 'ativo',
    ];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public static array $formasFarmaceuticas = [
        'comprimido'  => 'Comprimido',
        'capsula'     => 'Cápsula',
        'xarope'      => 'Xarope',
        'solucao_oral'=> 'Solução Oral',
        'suspensao'   => 'Suspensão',
        'injetavel'   => 'Injetável',
        'creme'       => 'Creme',
        'pomada'      => 'Pomada',
        'gel'         => 'Gel',
        'gotas'       => 'Gotas',
        'spray'       => 'Spray',
        'supositorio' => 'Supositório',
        'po'          => 'Pó',
        'sache'       => 'Sachê',
        'adesivo'     => 'Adesivo Transdérmico',
        'outros'      => 'Outros',
    ];

    public static array $periodicidades = [
        'mensal'     => 'Mensal',
        'bimestral'  => 'Bimestral',
        'trimestral' => 'Trimestral',
    ];

    public function tipoReceita()
    {
        return $this->belongsTo(TipoReceita::class);
    }

    public function cids()
    {
        return $this->belongsToMany(Cid10::class, 'medicamento_cid', 'medicamento_id', 'cid10_id');
    }

    public function processos()
    {
        return $this->belongsToMany(Processo::class, 'processo_medicamentos')
            ->withPivot(['periodicidade', 'quantidade_diaria', 'quantidade_mensal', 'posologia', 'observacoes']);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function lotesAtivos()
    {
        return $this->hasMany(Lote::class)->where('quantidade_atual', '>', 0)->where('validade', '>', now());
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function getFormaLabelAttribute(): string
    {
        return self::$formasFarmaceuticas[$this->forma_farmaceutica] ?? $this->forma_farmaceutica;
    }

    public function getNomeCompletoAttribute(): string
    {
        $partes = array_filter([$this->nome, $this->dosagem, $this->forma_label]);
        return implode(' — ', $partes);
    }
}

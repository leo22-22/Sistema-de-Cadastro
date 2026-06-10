<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $table = 'paciente_alergias';

    protected $fillable = [
        'paciente_id',
        'tipo',
        'descricao',
        'gravidade',
        'reacao',
    ];

    public static array $tipos = [
        'medicamento' => 'Medicamento',
        'substancia'  => 'Substância',
        'alimento'    => 'Alimento',
        'outro'       => 'Outro',
    ];

    public static array $gravidadeLabels = [
        'leve'         => 'Leve',
        'moderada'     => 'Moderada',
        'grave'        => 'Grave',
        'nao_informada'=> 'Não informada',
    ];

    public static array $gravidadeBadge = [
        'leve'         => 'bg-success',
        'moderada'     => 'bg-warning text-dark',
        'grave'        => 'bg-danger',
        'nao_informada'=> 'bg-secondary',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function getGravidadeLabelAttribute(): string
    {
        return self::$gravidadeLabels[$this->gravidade] ?? $this->gravidade;
    }

    public function getGravidadeBadgeAttribute(): string
    {
        return self::$gravidadeBadge[$this->gravidade] ?? 'bg-secondary';
    }

    public function getTipoLabelAttribute(): string
    {
        return self::$tipos[$this->tipo] ?? $this->tipo;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessoMedicamento extends Model
{
    public $timestamps = false;

    protected $table = 'processo_medicamentos';

    protected $fillable = [
        'processo_id', 'medicamento_id',
        'periodicidade', 'quantidade_diaria', 'quantidade_mensal',
        'posologia', 'observacoes',
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoDocumento extends Model
{
    use HasFactory;

    protected $table = 'processo_documentos';

    protected $fillable = [
        'processo_id', 'tipo', 'nome_original',
        'arquivo', 'tamanho', 'mime_type', 'enviado_por',
    ];

    public static array $tiposLabel = [
        'lme'              => 'LME',
        'receita'          => 'Receita',
        'exame'            => 'Exame',
        'documento_pessoal'=> 'Documento Pessoal',
        'outro'            => 'Outro',
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function enviador()
    {
        return $this->belongsTo(User::class, 'enviado_por');
    }

    public function getTipoLabelAttribute(): string
    {
        return self::$tiposLabel[$this->tipo] ?? $this->tipo;
    }

    public function getTamanhoFormatadoAttribute(): string
    {
        $bytes = $this->tamanho ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}

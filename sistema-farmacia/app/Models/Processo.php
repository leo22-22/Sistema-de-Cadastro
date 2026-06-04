<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmacia_id',
        'numero', 'tipo_processo',
        'paciente_id', 'cid10_id', 'medico_prescritor_id',
        'tipo_receita_id', 'tipo_relacao_remessa_id',
        'numero_receita', 'data_receita', 'data_validade_receita',
        'data_primeira_retirada', 'validade_apac',
        'status',
        'lme_entregue', 'receita_entregue', 'exame_entregue', 'documentos_entregues',
        'observacoes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'data_receita'           => 'date',
            'data_validade_receita'  => 'date',
            'data_primeira_retirada' => 'date',
            'validade_apac'          => 'date',
            'lme_entregue'           => 'boolean',
            'receita_entregue'       => 'boolean',
            'exame_entregue'         => 'boolean',
            'documentos_entregues'   => 'boolean',
        ];
    }

    public static array $tiposProcesso = [
        'abertura'     => 'Abertura',
        'retratado'    => 'Retratado',
        'transferencia'=> 'Transferência',
        'renovacao'    => 'Renovação',
        'continuidade' => 'Continuidade',
    ];

    public static function gerarNumero(): string
    {
        $ano = now()->year;
        $ultimo = static::whereYear('created_at', $ano)->count() + 1;
        return sprintf('PROC-%d-%04d', $ano, $ultimo);
    }

    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function cid10()
    {
        return $this->belongsTo(Cid10::class);
    }

    public function medicoPrescritor()
    {
        return $this->belongsTo(MedicoPrescritor::class);
    }

    public function tipoReceita()
    {
        return $this->belongsTo(TipoReceita::class);
    }

    public function tipoRelacaoRemessa()
    {
        return $this->belongsTo(TipoRelacaoRemessa::class);
    }

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'processo_medicamentos')
            ->withPivot(['periodicidade', 'quantidade_diaria', 'quantidade_mensal', 'posologia', 'observacoes']);
    }

    public function documentos()
    {
        return $this->hasMany(ProcessoDocumento::class);
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class);
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function podeConcluir(): bool
    {
        return in_array($this->status, ['aberto', 'em_andamento']);
    }

    public function podeCancelar(): bool
    {
        return in_array($this->status, ['aberto', 'em_andamento']);
    }

    public function podeDispensarMedicamento(): bool
    {
        return $this->status === 'em_andamento' || $this->status === 'concluido';
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'aberto'       => 'Aberto',
            'em_andamento' => 'Em Andamento',
            'concluido'    => 'Concluído',
            'cancelado'    => 'Cancelado',
            default        => $this->status,
        };
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'aberto'       => 'bg-primary',
            'em_andamento' => 'bg-warning text-dark',
            'concluido'    => 'bg-success',
            'cancelado'    => 'bg-danger',
            default        => 'bg-secondary',
        };
    }

    public function tipoProcessoLabel(): string
    {
        return self::$tiposProcesso[$this->tipo_processo] ?? $this->tipo_processo;
    }

    public function calcularValidadeApac(): ?\Carbon\Carbon
    {
        return $this->data_primeira_retirada?->addMonths(6);
    }
}

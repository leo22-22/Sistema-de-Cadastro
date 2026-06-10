<?php

namespace App\Notifications;

use App\Models\Processo;
use Illuminate\Notifications\Notification;

class ProcessoStatusNotification extends Notification
{
    public function __construct(public Processo $processo, public string $statusAnterior) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo'   => 'processo_status',
            'icone'  => 'bi-arrow-repeat',
            'cor'    => 'info',
            'titulo' => 'Status do processo alterado',
            'corpo'  => "Processo {$this->processo->numero} ({$this->processo->paciente->nome}) mudou de {$this->statusAnterior} para {$this->processo->statusLabel()}.",
            'link'   => route('processos.show', $this->processo->id),
        ];
    }
}

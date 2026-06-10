<?php

namespace App\Notifications;

use App\Models\Processo;
use Illuminate\Notifications\Notification;

class ApacVencendoNotification extends Notification
{
    public function __construct(public Processo $processo) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $dias = now()->diffInDays($this->processo->validade_apac, false);

        return [
            'tipo'   => 'apac_vencendo',
            'icone'  => 'bi-calendar-x-fill',
            'cor'    => $dias <= 7 ? 'danger' : 'warning',
            'titulo' => 'APAC vencendo em breve',
            'corpo'  => "Processo {$this->processo->numero} ({$this->processo->paciente->nome}) vence em {$dias} dias ({$this->processo->validade_apac->format('d/m/Y')}).",
            'link'   => route('processos.show', $this->processo->id),
        ];
    }
}

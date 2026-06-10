<?php

namespace App\Notifications;

use App\Models\Lote;
use Illuminate\Notifications\Notification;

class LoteVencendoNotification extends Notification
{
    public function __construct(public Lote $lote) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $dias = now()->diffInDays($this->lote->validade, false);

        return [
            'tipo'    => 'lote_vencendo',
            'icone'   => 'bi-exclamation-triangle-fill',
            'cor'     => $dias <= 7 ? 'danger' : 'warning',
            'titulo'  => 'Lote vencendo em breve',
            'corpo'   => "Lote {$this->lote->lote} de {$this->lote->medicamento->nome} vence em {$dias} dias ({$this->lote->validade->format('d/m/Y')}).",
            'link'    => route('lotes.show', $this->lote->id),
        ];
    }
}

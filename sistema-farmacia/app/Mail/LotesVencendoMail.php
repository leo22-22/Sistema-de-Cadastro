<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LotesVencendoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly \Illuminate\Support\Collection $lotes30,
        public readonly \Illuminate\Support\Collection $lotesBaixoEstoque,
        public readonly string $nomeDestino,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[FarmáciaMuni] Alerta: lotes vencendo e estoque baixo',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lotes-vencendo',
        );
    }
}

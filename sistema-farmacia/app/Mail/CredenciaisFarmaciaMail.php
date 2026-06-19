<?php

namespace App\Mail;

use App\Models\Farmacia;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CredenciaisFarmaciaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Farmacia $farmacia,
        public readonly string   $emailAdmin,
        public readonly string   $nomeAdmin,
        public readonly string   $senha,
        public readonly string   $urlSistema,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[GovSaúde] Bem-vindo! Suas credenciais de acesso',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.credenciais-farmacia',
        );
    }
}

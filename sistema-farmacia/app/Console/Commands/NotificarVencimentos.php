<?php

namespace App\Console\Commands;

use App\Mail\LotesVencendoMail;
use App\Models\Farmacia;
use App\Models\Lote;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotificarVencimentos extends Command
{
    protected $signature   = 'farmacia:notificar-vencimentos';
    protected $description = 'Envia e-mail de alerta de lotes vencendo e estoque baixo para admins de cada farmácia';

    public function handle(): void
    {
        $farmacias = Farmacia::where('ativo', true)->get();

        foreach ($farmacias as $farmacia) {
            $lotes30 = Lote::with('medicamento')
                ->where('farmacia_id', $farmacia->id)
                ->where('quantidade_atual', '>', 0)
                ->whereBetween('validade', [now(), now()->addDays(30)])
                ->orderBy('validade')
                ->get();

            $lotesBaixo = Lote::with('medicamento')
                ->where('farmacia_id', $farmacia->id)
                ->where('quantidade_atual', '>', 0)
                ->where('quantidade_atual', '<=', 10)
                ->where('validade', '>=', now())
                ->get();

            if ($lotes30->isEmpty() && $lotesBaixo->isEmpty()) {
                continue;
            }

            $admins = User::where('farmacia_id', $farmacia->id)
                ->where('role', 'admin_farmacia')
                ->where('active', true)
                ->whereNotNull('email')
                ->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(
                    new LotesVencendoMail($lotes30, $lotesBaixo, $admin->name)
                );
                $this->line("Notificação enviada para {$admin->email} ({$farmacia->nome})");
            }
        }

        $this->info('Notificações de vencimento processadas.');
    }
}

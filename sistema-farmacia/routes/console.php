<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Envia e-mail de alerta de vencimentos toda segunda-feira às 8h
Schedule::command('farmacia:notificar-vencimentos')->weeklyOn(1, '08:00');

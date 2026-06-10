<?php

namespace App\Providers;

use App\Helpers\DocumentoHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Validator::extend('cpf', function ($attribute, $value) {
            return DocumentoHelper::validarCpf($value);
        }, 'CPF inválido.');

        Validator::extend('cnpj', function ($attribute, $value) {
            return DocumentoHelper::validarCnpj($value);
        }, 'CNPJ inválido.');

        Validator::extend('crm', function ($attribute, $value) {
            return DocumentoHelper::validarCrm($value);
        }, 'CRM inválido (deve conter 4 a 6 dígitos).');
    }
}

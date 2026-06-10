<?php

namespace App\Helpers;

class DocumentoHelper
{
    public static function validarCpf(?string $cpf): bool
    {
        if (!$cpf) return false;
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += (int)$cpf[$c] * ($t + 1 - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int)$cpf[$c] !== $d) return false;
        }
        return true;
    }

    public static function validarCnpj(?string $cnpj): bool
    {
        if (!$cnpj) return false;
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) return false;

        $calc = function (string $cnpj, int $len): int {
            $sum = 0;
            $pos = $len - 7;
            for ($i = $len; $i >= 1; $i--) {
                $sum += (int)$cnpj[$len - $i] * $pos--;
                if ($pos < 2) $pos = 9;
            }
            return $sum % 11 < 2 ? 0 : 11 - ($sum % 11);
        };

        return (int)$cnpj[12] === $calc($cnpj, 12) && (int)$cnpj[13] === $calc($cnpj, 13);
    }

    public static function validarCrm(?string $crm): bool
    {
        if (!$crm) return false;
        return (bool) preg_match('/^\d{4,6}$/', preg_replace('/\D/', '', $crm));
    }

    public static function mascaraCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    public static function mascaraCnpj(string $cnpj): string
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }
}

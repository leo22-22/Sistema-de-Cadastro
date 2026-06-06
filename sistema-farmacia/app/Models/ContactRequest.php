<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = [
        'nome', 'email', 'telefone', 'municipio', 'estado', 'mensagem', 'lido',
    ];

    protected function casts(): array
    {
        return ['lido' => 'boolean'];
    }
}

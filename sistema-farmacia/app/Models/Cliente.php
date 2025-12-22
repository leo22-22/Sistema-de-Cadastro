<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome_fantasia', 
        'razao_social', 
        'tipo', 
        'documento', 
        'telefone', 
        'email', 
        'observacoes'
    ];
}
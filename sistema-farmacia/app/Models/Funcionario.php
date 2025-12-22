<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nome_completo', 
        'cpf', 
        'rg', 
        'cargo', 
        'salario', 
        'bonificacao', 
        'data_admissao', 
        'status'
    ];
}
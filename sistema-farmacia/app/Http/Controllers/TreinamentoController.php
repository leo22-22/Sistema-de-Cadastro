<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreinamentoController extends Controller
{
    public function index()
    {
        return view('treinamento.index');
    }
}

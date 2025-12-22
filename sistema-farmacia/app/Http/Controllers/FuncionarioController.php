<?php
namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function create() {
        return view('funcionarios.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nome_completo' => 'required',
            'cpf'           => 'required|unique:funcionarios,cpf',
            'salario'       => 'required|numeric',
        ]);

        Funcionario::create($request->all());

        return redirect()->route('home')->with('success', 'Funcionário registado com sucesso!');
    }
}
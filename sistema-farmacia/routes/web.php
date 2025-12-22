<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Abertas para todos)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Retorna a sua landing page principal
    return view('index');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Apenas para empresas logadas e assinantes)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard principal do usuário
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestão de Clientes (Lojinha / Barbearia / Empresa Grande)
    Route::resource('clientes', ClienteController::class);

    // Gestão de Funcionários (Salários / Documentos / Bonificações)
    Route::resource('funcionarios', FuncionarioController::class);

    // Área de Inteligência e Relatórios (Demanda diária, semanal, mensal)
    Route::get('/relatorios', function () {
        return view('relatorios'); // Certifique-se de criar este arquivo depois
    })->name('relatorios');

    // Perfil do Usuário (Gerado pelo Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
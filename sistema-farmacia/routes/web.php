<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicoPrescritController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\TipoReceitaController;
use App\Http\Controllers\TipoRelacaoRemessaController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\ReciboController;
use App\Models\Processo;
use App\Models\Paciente;
use App\Models\Recibo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $totalPacientes        = Paciente::ativo()->count();
        $totalProcessos        = Processo::count();
        $processosAbertos      = Processo::where('status', 'aberto')->count();
        $processosEmAndamento  = Processo::where('status', 'em_andamento')->count();
        $processosConcluidos   = Processo::where('status', 'concluido')->count();
        $totalRecibos          = Recibo::count();
        $recentes              = Processo::with(['paciente', 'cid10', 'criadoPor'])
            ->latest()->take(8)->get();
        $apacAlerta            = Processo::with('paciente')
            ->whereNotNull('validade_apac')
            ->whereIn('status', ['aberto', 'em_andamento'])
            ->where('validade_apac', '<=', now()->addDays(30))
            ->orderBy('validade_apac')
            ->get();

        return view('dashboard', compact(
            'totalPacientes', 'totalProcessos', 'processosAbertos',
            'processosEmAndamento', 'processosConcluidos',
            'totalRecibos', 'recentes', 'apacAlerta'
        ));
    })->name('dashboard');

    // Pacientes
    Route::resource('pacientes', PacienteController::class);
    Route::post('pacientes/{paciente}/representantes', [PacienteController::class, 'vincularRepresentante'])
        ->name('pacientes.vincularRepresentante');
    Route::delete('pacientes/{paciente}/representantes/{representante}', [PacienteController::class, 'desvincularRepresentante'])
        ->name('pacientes.desvincularRepresentante');

    // Representantes
    Route::resource('representantes', RepresentanteController::class);

    // Médicos Prescritores
    Route::resource('medicos-prescritores', MedicoPrescritController::class)
        ->parameters(['medicos-prescritores' => 'medico'])
        ->names([
            'index'   => 'medicos-prescritores.index',
            'create'  => 'medicos-prescritores.create',
            'store'   => 'medicos-prescritores.store',
            'show'    => 'medicos-prescritores.show',
            'edit'    => 'medicos-prescritores.edit',
            'update'  => 'medicos-prescritores.update',
            'destroy' => 'medicos-prescritores.destroy',
        ]);

    // Processos
    Route::resource('processos', ProcessoController::class);
    Route::patch('processos/{processo}/status', [ProcessoController::class, 'atualizarStatus'])
        ->name('processos.status');
    Route::post('processos/{processo}/documentos', [ProcessoController::class, 'uploadDocumento'])
        ->name('processos.documentos.upload');
    Route::delete('processos/{processo}/documentos/{documento}', [ProcessoController::class, 'deleteDocumento'])
        ->name('processos.documentos.delete');

    // Recibos / Dispensação
    Route::resource('recibos', ReciboController::class)->only(['index', 'show', 'destroy']);
    Route::get('recibos/{recibo}/imprimir', [ReciboController::class, 'imprimir'])->name('recibos.imprimir');
    Route::get('processos/{processo}/dispensar', [ReciboController::class, 'create'])->name('recibos.create');
    Route::post('processos/{processo}/dispensar', [ReciboController::class, 'store'])->name('recibos.store');

    // Lotes (estoque de medicamentos)
    Route::resource('lotes', LoteController::class)->names([
        'index'   => 'lotes.index',
        'create'  => 'lotes.create',
        'store'   => 'lotes.store',
        'show'    => 'lotes.show',
        'edit'    => 'lotes.edit',
        'update'  => 'lotes.update',
        'destroy' => 'lotes.destroy',
    ]);

    // Área restrita ao Superadmin
    Route::middleware('superadmin')->group(function () {
        Route::resource('usuarios', UserController::class)->except(['show']);
        Route::resource('medicamentos', MedicamentoController::class);
        Route::resource('tipos-receita', TipoReceitaController::class)->names([
            'index'   => 'tipos-receita.index',
            'create'  => 'tipos-receita.create',
            'store'   => 'tipos-receita.store',
            'edit'    => 'tipos-receita.edit',
            'update'  => 'tipos-receita.update',
            'destroy' => 'tipos-receita.destroy',
        ]);
        Route::resource('tipos-relacao-remessa', TipoRelacaoRemessaController::class)->names([
            'index'   => 'tipos-relacao-remessa.index',
            'create'  => 'tipos-relacao-remessa.create',
            'store'   => 'tipos-relacao-remessa.store',
            'edit'    => 'tipos-relacao-remessa.edit',
            'update'  => 'tipos-relacao-remessa.update',
            'destroy' => 'tipos-relacao-remessa.destroy',
        ]);
    });

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\FarmaciaController;
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
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ContactController;
use App\Models\Lote;
use App\Models\Processo;
use App\Models\Paciente;
use App\Models\Recibo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Legal + Status (public, no auth required)
Route::get('termos',      [\App\Http\Controllers\LegalController::class, 'termos'])->name('legal.termos');
Route::get('privacidade', [\App\Http\Controllers\LegalController::class, 'privacidade'])->name('legal.privacidade');
Route::get('status',      [\App\Http\Controllers\StatusController::class, 'index'])->name('status.index');

// Formulário de contato público (sem autenticação)
Route::post('/contato', [ContactController::class, 'store'])->name('contato.store');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isSuperadmin()) {
            $totalFarmacias  = \App\Models\Farmacia::count();
            $farmaciasAtivas = \App\Models\Farmacia::where('ativo', true)->count();
            $totalUsuarios   = \App\Models\User::where('role', '!=', 'superadmin')->count();
            $totalProcessos  = Processo::count();
            $totalRecibos    = Recibo::count();
            $totalMedicamentos = \App\Models\Medicamento::where('ativo', true)->count();
            $ultimasFarmacias  = \App\Models\Farmacia::withCount('users')->latest()->take(6)->get();

            return view('dashboard-superadmin', compact(
                'totalFarmacias', 'farmaciasAtivas', 'totalUsuarios',
                'totalProcessos', 'totalRecibos', 'totalMedicamentos',
                'ultimasFarmacias'
            ));
        }

        $processoQuery = Processo::query();
        $reciboQuery   = Recibo::query();
        $resenteQuery  = Processo::with(['paciente', 'cid10', 'criadoPor']);
        $apacQuery     = Processo::with('paciente');

        if ($user->farmacia_id) {
            $processoQuery->where('farmacia_id', $user->farmacia_id);
            $reciboQuery->whereHas('processo', fn($q) => $q->where('farmacia_id', $user->farmacia_id));
            $resenteQuery->where('farmacia_id', $user->farmacia_id);
            $apacQuery->where('farmacia_id', $user->farmacia_id);
        }

        $totalPacientes       = Paciente::ativo()->count();
        $totalProcessos       = $processoQuery->count();
        $processosAbertos     = (clone $processoQuery)->where('status', 'aberto')->count();
        $processosEmAndamento = (clone $processoQuery)->where('status', 'em_andamento')->count();
        $processosConcluidos  = (clone $processoQuery)->where('status', 'concluido')->count();
        $totalRecibos         = $reciboQuery->count();
        $recentes             = $resenteQuery->latest()->take(8)->get();
        $apacAlerta           = $apacQuery
            ->whereNotNull('validade_apac')
            ->whereIn('status', ['aberto', 'em_andamento'])
            ->where('validade_apac', '<=', now()->addDays(30))
            ->orderBy('validade_apac')
            ->get();

        $loteQuery30 = Lote::with('medicamento')->where('quantidade_atual', '>', 0)
            ->whereBetween('validade', [now(), now()->addDays(30)]);
        $loteQuery90 = Lote::with('medicamento')->where('quantidade_atual', '>', 0)
            ->whereBetween('validade', [now()->addDays(31), now()->addDays(90)]);

        if ($user->farmacia_id) {
            $loteQuery30->where('farmacia_id', $user->farmacia_id);
            $loteQuery90->where('farmacia_id', $user->farmacia_id);
        }

        $lotesVencendo30 = $loteQuery30->orderBy('validade')->get();
        $lotesVencendo90 = $loteQuery90->orderBy('validade')->get();

        return view('dashboard', compact(
            'totalPacientes', 'totalProcessos', 'processosAbertos',
            'processosEmAndamento', 'processosConcluidos',
            'totalRecibos', 'recentes', 'apacAlerta',
            'lotesVencendo30', 'lotesVencendo90'
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
    Route::post('processos/{processo}/renovar', [ProcessoController::class, 'renovar'])
        ->name('processos.renovar');
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

    // Relatórios
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::get('relatorios/dispensacoes', [RelatorioController::class, 'dispensacoes'])->name('relatorios.dispensacoes');
    Route::get('relatorios/estoque', [RelatorioController::class, 'estoque'])->name('relatorios.estoque');
    Route::get('relatorios/processos', [RelatorioController::class, 'processos'])->name('relatorios.processos');

    // Auditoria
    Route::get('auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');

    // Treinamento
    Route::get('treinamento', [\App\Http\Controllers\TreinamentoController::class, 'index'])->name('treinamento.index');

    // Backup (superadmin full access + admin_farmacia read-only)
    Route::get('backup',                        [\App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::post('backup',                       [\App\Http\Controllers\BackupController::class, 'store'])->name('backup.store');
    Route::get('backup/{filename}/download',    [\App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
    Route::delete('backup/{filename}',          [\App\Http\Controllers\BackupController::class, 'destroy'])->name('backup.destroy');

    // Gestão de usuários — superadmin vê todos, admin_farmacia vê só os seus
    Route::middleware('admin_farmacia')->group(function () {
        Route::resource('usuarios', UserController::class)->except(['show']);
    });

    // Área restrita ao Superadmin (plataforma)
    Route::middleware('superadmin')->group(function () {
        Route::resource('farmacias', FarmaciaController::class)->except(['show']);
        Route::get('solicitacoes', [ContactController::class, 'index'])->name('contato.index');
        Route::patch('solicitacoes/{contactRequest}/lido', [ContactController::class, 'marcarLido'])->name('contato.lido');
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

        // RNDS
        Route::get('rnds',  [\App\Http\Controllers\RndsController::class, 'index'])->name('rnds.index');
        Route::post('rnds', [\App\Http\Controllers\RndsController::class, 'update'])->name('rnds.update');
    });

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

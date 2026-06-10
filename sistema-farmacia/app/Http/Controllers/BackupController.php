<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller {
    public function index() {
        $backups = $this->listBackups();
        $isSuperadmin = auth()->user()->isSuperadmin();
        return view('superadmin.backup', compact('backups', 'isSuperadmin'));
    }

    public function store() {
        abort_unless(auth()->user()->isSuperadmin(), 403);
        try {
            Artisan::call('app:backup-database');
            return back()->with('success', 'Backup criado com sucesso!');
        } catch(\Exception $e) {
            return back()->with('error', 'Erro ao criar backup: ' . $e->getMessage());
        }
    }

    public function download($filename) {
        abort_unless(auth()->user()->isSuperadmin(), 403);
        $path = storage_path('app/backups/' . basename($filename));
        abort_unless(file_exists($path), 404);
        return response()->download($path);
    }

    public function destroy($filename) {
        abort_unless(auth()->user()->isSuperadmin(), 403);
        $path = storage_path('app/backups/' . basename($filename));
        if (file_exists($path)) unlink($path);
        return back()->with('success', 'Backup excluído.');
    }

    private function listBackups(): array {
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) return [];
        $files = glob($dir . '/*.sql') ?: [];
        usort($files, fn($a,$b) => filemtime($b) - filemtime($a));
        return array_map(fn($f) => [
            'filename'   => basename($f),
            'size'       => filesize($f),
            'created_at' => \Carbon\Carbon::createFromTimestamp(filemtime($f)),
        ], $files);
    }
}

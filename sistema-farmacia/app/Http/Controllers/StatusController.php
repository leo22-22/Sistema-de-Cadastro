<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller {
    public function index() {
        // DB check
        try { DB::select('SELECT 1'); $dbOk = true; } catch(\Exception $e) { $dbOk = false; }

        // Last backup
        $backupDir = storage_path('app/backups');
        $lastBackup = null;
        if (is_dir($backupDir)) {
            $files = glob($backupDir . '/*.sql');
            if ($files) {
                $latest = max(array_map('filemtime', $files));
                $lastBackup = \Carbon\Carbon::createFromTimestamp($latest);
            }
        }

        // Disk space
        $diskFree  = disk_free_space(storage_path());
        $diskTotal = disk_total_space(storage_path());
        $diskPct   = $diskTotal ? round(($diskTotal - $diskFree) / $diskTotal * 100) : 0;

        return view('status.index', compact('dbOk', 'lastBackup', 'diskFree', 'diskTotal', 'diskPct'));
    }
}

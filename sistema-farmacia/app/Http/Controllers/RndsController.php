<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RndsController extends Controller {
    private string $configPath;

    public function __construct() {
        $this->configPath = storage_path('app/rnds_config.json');
    }

    public function index() {
        $config = $this->loadConfig();
        return view('superadmin.rnds', compact('config'));
    }

    public function update(Request $request) {
        $data = $request->validate([
            'cnpj'            => 'nullable|string|max:20',
            'cpf_habilitador' => 'nullable|string|max:14',
            'ambiente'        => 'nullable|in:homologacao,producao',
            'ativo'           => 'boolean',
        ]);
        $data['ambiente'] = $data['ambiente'] ?? $this->loadConfig()['ambiente'] ?? 'homologacao';
        $data['ativo'] = $request->boolean('ativo');
        $data['updated_at'] = now()->toIso8601String();
        file_put_contents($this->configPath, json_encode($data, JSON_PRETTY_PRINT));
        return back()->with('success', 'Configurações RNDS salvas.');
    }

    private function loadConfig(): array {
        if (!file_exists($this->configPath)) return [
            'cnpj' => '', 'cpf_habilitador' => '',
            'ambiente' => 'homologacao', 'ativo' => false, 'updated_at' => null,
        ];
        return json_decode(file_get_contents($this->configPath), true) ?? [];
    }
}

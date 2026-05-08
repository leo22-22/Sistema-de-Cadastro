<?php

namespace App\Http\Controllers;

use App\Models\MedicoPrescritor;
use Illuminate\Http\Request;

class MedicoPrescritController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicoPrescritor::query();
        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', "%{$request->busca}%")
                  ->orWhere('crm', 'like', "%{$request->busca}%")
                  ->orWhere('estabelecimento', 'like', "%{$request->busca}%");
            });
        }
        $medicos = $query->latest()->paginate(20)->withQueryString();
        return view('medicos-prescritores.index', compact('medicos'));
    }

    public function create()
    {
        return view('medicos-prescritores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'           => 'required|string|max:255',
            'crm'            => 'nullable|string|max:20',
            'cns'            => 'nullable|string|max:15',
            'cnes'           => 'nullable|string|max:10',
            'estabelecimento'=> 'nullable|string|max:255',
            'especialidade'  => 'nullable|string|max:100',
            'telefone'       => 'nullable|string|max:20',
            'cidade'         => 'nullable|string|max:100',
            'uf'             => 'nullable|string|max:2',
        ]);

        MedicoPrescritor::create([...$data, 'ativo' => true]);
        return redirect()->route('medicos-prescritores.index')
            ->with('success', 'Médico cadastrado com sucesso.');
    }

    public function show(MedicoPrescritor $medico)
    {
        $medico->load(['processos.paciente', 'processos.cid10']);
        return view('medicos-prescritores.show', compact('medico'));
    }

    public function edit(MedicoPrescritor $medico)
    {
        return view('medicos-prescritores.edit', compact('medico'));
    }

    public function update(Request $request, MedicoPrescritor $medico)
    {
        $data = $request->validate([
            'nome'           => 'required|string|max:255',
            'crm'            => 'nullable|string|max:20',
            'cns'            => 'nullable|string|max:15',
            'cnes'           => 'nullable|string|max:10',
            'estabelecimento'=> 'nullable|string|max:255',
            'especialidade'  => 'nullable|string|max:100',
            'telefone'       => 'nullable|string|max:20',
            'cidade'         => 'nullable|string|max:100',
            'uf'             => 'nullable|string|max:2',
            'ativo'          => 'boolean',
        ]);

        $medico->update($data);
        return redirect()->route('medicos-prescritores.index')
            ->with('success', 'Médico atualizado com sucesso.');
    }

    public function destroy(MedicoPrescritor $medico)
    {
        $medico->delete();
        return back()->with('success', 'Médico removido.');
    }
}

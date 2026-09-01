<?php

namespace App\Http\Controllers;

use App\Models\MedicoPrescritor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nome'           => ['nullable', 'string', 'max:255'],
            'crm'            => ['nullable', 'string', 'max:20', 'crm'],
            'cns'            => ['nullable', 'string', 'max:20'],
            'cnes'           => ['nullable', 'string', 'max:7'],
            'estabelecimento'=> ['nullable', 'string', 'max:255'],
            'especialidade'  => ['nullable', 'string', 'max:100'],
            'telefone'       => ['nullable', 'string', 'max:15'],
            'cidade'         => ['nullable', 'string', 'max:100'],
            'uf'             => ['nullable', 'string', 'size:2'],
        ], [
            'crm.crm' => 'CRM inválido. O CRM deve conter entre 4 e 6 dígitos numéricos.',
        ]);

        $validator->after(function ($v) use ($request) {
            $crm = $request->input('crm');
            $cns = $request->input('cns');

            if ($crm && !$v->errors()->has('crm')) {
                $dup = MedicoPrescritor::where('crm', $crm)->first();
                if ($dup) {
                    $v->errors()->add('crm', "Este CRM já está cadastrado para o(a) Dr(a). {$dup->nome}.");
                }
            }

            if ($cns && !$v->errors()->has('cns')) {
                $dup = MedicoPrescritor::where('cns', $cns)->first();
                if ($dup) {
                    $v->errors()->add('cns', "Este CNS já está cadastrado para o(a) Dr(a). {$dup->nome}.");
                }
            }
        });

        $data = $validator->validate();

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
        $validator = Validator::make($request->all(), [
            'nome'           => ['nullable', 'string', 'max:255'],
            'crm'            => ['nullable', 'string', 'max:20', 'crm'],
            'cns'            => ['nullable', 'string', 'max:20'],
            'cnes'           => ['nullable', 'string', 'max:7'],
            'estabelecimento'=> ['nullable', 'string', 'max:255'],
            'especialidade'  => ['nullable', 'string', 'max:100'],
            'telefone'       => ['nullable', 'string', 'max:15'],
            'cidade'         => ['nullable', 'string', 'max:100'],
            'uf'             => ['nullable', 'string', 'size:2'],
            'ativo'          => ['boolean'],
        ], [
            'crm.crm' => 'CRM inválido. O CRM deve conter entre 4 e 6 dígitos numéricos.',
        ]);

        $validator->after(function ($v) use ($request, $medico) {
            $crm = $request->input('crm');
            $cns = $request->input('cns');

            if ($crm && !$v->errors()->has('crm')) {
                $dup = MedicoPrescritor::where('crm', $crm)->where('id', '!=', $medico->id)->first();
                if ($dup) {
                    $v->errors()->add('crm', "Este CRM já está cadastrado para o(a) Dr(a). {$dup->nome}.");
                }
            }

            if ($cns && !$v->errors()->has('cns')) {
                $dup = MedicoPrescritor::where('cns', $cns)->where('id', '!=', $medico->id)->first();
                if ($dup) {
                    $v->errors()->add('cns', "Este CNS já está cadastrado para o(a) Dr(a). {$dup->nome}.");
                }
            }
        });

        $data = $validator->validate();

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

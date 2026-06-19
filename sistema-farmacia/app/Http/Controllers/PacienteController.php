<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Representante;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::query();

        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', "%{$request->busca}%")
                  ->orWhere('cpf', 'like', "%{$request->busca}%")
                  ->orWhere('cns', 'like', "%{$request->busca}%")
                  ->orWhere('prontuario', 'like', "%{$request->busca}%");
            });
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }

        $pacientes = $query->orderBy('nome')->paginate(15)->withQueryString();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        $representantes = Representante::ativo()->orderBy('nome')->get();
        return view('pacientes.create', compact('representantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'             => ['required', 'string', 'max:255'],
            'nome_mae'         => ['nullable', 'string', 'max:255'],
            'cpf'              => ['nullable', 'string', 'max:14', 'unique:pacientes,cpf', 'cpf'],
            'rg'               => ['nullable', 'string', 'max:20'],
            'cns'              => ['nullable', 'string', 'max:20', 'unique:pacientes,cns'],
            'prontuario'       => ['nullable', 'string', 'max:50'],
            'data_nascimento'  => ['nullable', 'date', 'before:today'],
            'raca_cor'         => ['nullable', 'in:branca,preta,parda,amarela,indigena,nao_informada'],
            'peso'             => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura'           => ['nullable', 'integer', 'min:30', 'max:250'],
            'telefone'         => ['nullable', 'string', 'max:20'],
            'email'            => ['nullable', 'email', 'max:255'],
            'logradouro'       => ['nullable', 'string', 'max:255'],
            'numero_endereco'  => ['nullable', 'string', 'max:20'],
            'complemento'      => ['nullable', 'string', 'max:100'],
            'bairro'           => ['nullable', 'string', 'max:100'],
            'cidade'           => ['nullable', 'string', 'max:100'],
            'uf'               => ['nullable', 'string', 'size:2'],
            'cep'              => ['nullable', 'string', 'max:10'],
            'sem_representante'=> ['boolean'],
            'observacoes'      => ['nullable', 'string'],
        ]);

        $data['sem_representante'] = $request->boolean('sem_representante');
        $paciente = Paciente::create([...$data, 'ativo' => true, 'created_by' => auth()->id()]);

        if (!$data['sem_representante'] && $request->filled('representantes')) {
            foreach ($request->representantes as $ordem => $repId) {
                if ($repId) {
                    $paciente->representantes()->attach($repId, ['ordem' => $ordem + 1]);
                }
            }
        }

        return redirect()->route('pacientes.show', $paciente)
            ->with('success', 'Paciente cadastrado com sucesso.');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load([
            'representantes',
            'alergias',
            'processos.cid10',
            'processos.criadoPor',
            'processos.medicoPrescritor',
            'processos.recibos.medicamento',
        ]);
        $representantesDisponiveis = Representante::ativo()->orderBy('nome')->get();
        return view('pacientes.show', compact('paciente', 'representantesDisponiveis'));
    }

    public function edit(Paciente $paciente)
    {
        $paciente->load('representantes');
        $representantes = Representante::ativo()->orderBy('nome')->get();
        return view('pacientes.edit', compact('paciente', 'representantes'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $data = $request->validate([
            'nome'             => ['required', 'string', 'max:255'],
            'nome_mae'         => ['nullable', 'string', 'max:255'],
            'cpf'              => ['nullable', 'string', 'max:14', "unique:pacientes,cpf,{$paciente->id}", 'cpf'],
            'rg'               => ['nullable', 'string', 'max:20'],
            'cns'              => ['nullable', 'string', 'max:20', "unique:pacientes,cns,{$paciente->id}"],
            'prontuario'       => ['nullable', 'string', 'max:50'],
            'data_nascimento'  => ['nullable', 'date', 'before:today'],
            'raca_cor'         => ['nullable', 'in:branca,preta,parda,amarela,indigena,nao_informada'],
            'peso'             => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura'           => ['nullable', 'integer', 'min:30', 'max:250'],
            'telefone'         => ['nullable', 'string', 'max:20'],
            'email'            => ['nullable', 'email', 'max:255'],
            'logradouro'       => ['nullable', 'string', 'max:255'],
            'numero_endereco'  => ['nullable', 'string', 'max:20'],
            'complemento'      => ['nullable', 'string', 'max:100'],
            'bairro'           => ['nullable', 'string', 'max:100'],
            'cidade'           => ['nullable', 'string', 'max:100'],
            'uf'               => ['nullable', 'string', 'size:2'],
            'cep'              => ['nullable', 'string', 'max:10'],
            'sem_representante'=> ['boolean'],
            'ativo'            => ['boolean'],
            'observacoes'      => ['nullable', 'string'],
        ]);

        $data['sem_representante'] = $request->boolean('sem_representante');
        $data['ativo']             = $request->boolean('ativo', true);
        $paciente->update($data);

        if (!$data['sem_representante'] && $request->filled('representantes')) {
            $sync = [];
            foreach ($request->representantes as $ordem => $repId) {
                if ($repId) {
                    $sync[$repId] = ['ordem' => $ordem + 1];
                }
            }
            $paciente->representantes()->sync($sync);
        } elseif ($data['sem_representante']) {
            $paciente->representantes()->detach();
        }

        return redirect()->route('pacientes.show', $paciente)
            ->with('success', 'Paciente atualizado com sucesso.');
    }

    public function destroy(Paciente $paciente)
    {
        if ($paciente->processos()->exists()) {
            return back()->with('error', 'Não é possível excluir um paciente com processos vinculados.');
        }
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente removido.');
    }

    public function vincularRepresentante(Request $request, Paciente $paciente)
    {
        $request->validate([
            'representante_id' => ['required', 'exists:representantes,id'],
            'ordem'            => ['nullable', 'integer', 'min:1', 'max:3'],
        ]);

        if ($paciente->representantes()->count() >= 3) {
            return back()->with('error', 'Um paciente pode ter no máximo 3 representantes.');
        }

        $ordem = $request->ordem ?? ($paciente->representantes()->count() + 1);
        $paciente->representantes()->syncWithoutDetaching([
            $request->representante_id => ['ordem' => $ordem],
        ]);

        $paciente->update(['sem_representante' => false]);
        return back()->with('success', 'Representante vinculado.');
    }

    public function desvincularRepresentante(Paciente $paciente, Representante $representante)
    {
        $paciente->representantes()->detach($representante->id);
        return back()->with('success', 'Representante desvinculado.');
    }
}

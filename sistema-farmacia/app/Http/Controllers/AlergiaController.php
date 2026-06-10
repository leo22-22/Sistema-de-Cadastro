<?php

namespace App\Http\Controllers;

use App\Models\Alergia;
use App\Models\Paciente;
use Illuminate\Http\Request;

class AlergiaController extends Controller
{
    public function store(Request $request, Paciente $paciente)
    {
        $request->validate([
            'tipo'      => ['required', 'in:medicamento,substancia,alimento,outro'],
            'descricao' => ['required', 'string', 'max:255'],
            'gravidade' => ['required', 'in:leve,moderada,grave,nao_informada'],
            'reacao'    => ['nullable', 'string', 'max:500'],
        ]);

        $paciente->alergias()->create($request->only('tipo', 'descricao', 'gravidade', 'reacao'));

        return back()->with('success', 'Alergia registrada com sucesso.');
    }

    public function destroy(Paciente $paciente, Alergia $alergia)
    {
        abort_unless($alergia->paciente_id === $paciente->id, 403);
        $alergia->delete();
        return back()->with('success', 'Alergia removida.');
    }
}

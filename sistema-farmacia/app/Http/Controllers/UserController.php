<?php

namespace App\Http\Controllers;

use App\Models\Farmacia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = User::with('farmacia')->orderBy('name');

        if (!$user->isSuperadmin()) {
            $query->where('farmacia_id', $user->farmacia_id);
        }

        $usuarios = $query->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $farmacias = auth()->user()->isSuperadmin()
            ? Farmacia::ativo()->orderBy('nome')->get()
            : collect();

        return view('usuarios.create', compact('farmacias'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rolesPermitidos = $user->isSuperadmin()
            ? ['superadmin', 'admin_farmacia', 'funcionario']
            : ['admin_farmacia', 'funcionario'];

        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'         => ['required', 'in:' . implode(',', $rolesPermitidos)],
            'farmacia_id'  => ['nullable', 'exists:farmacias,id'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $farmaciaId = $user->isSuperadmin()
            ? $request->farmacia_id
            : $user->farmacia_id;

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'active'      => true,
            'farmacia_id' => $farmaciaId,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $usuario)
    {
        $this->autorizarAcesso($usuario);

        $farmacias = auth()->user()->isSuperadmin()
            ? Farmacia::ativo()->orderBy('nome')->get()
            : collect();

        return view('usuarios.edit', compact('usuario', 'farmacias'));
    }

    public function update(Request $request, User $usuario)
    {
        $this->autorizarAcesso($usuario);

        $user = auth()->user();

        $rolesPermitidos = $user->isSuperadmin()
            ? ['superadmin', 'admin_farmacia', 'funcionario']
            : ['admin_farmacia', 'funcionario'];

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'role'        => ['required', 'in:' . implode(',', $rolesPermitidos)],
            'farmacia_id' => ['nullable', 'exists:farmacias,id'],
            'active'      => ['boolean'],
        ]);

        $data = $request->only(['name', 'email', 'role']);
        $data['active'] = $request->boolean('active');

        if ($user->isSuperadmin()) {
            $data['farmacia_id'] = $request->farmacia_id;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $usuario)
    {
        $this->autorizarAcesso($usuario);

        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'Você não pode excluir sua própria conta aqui.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário removido com sucesso.');
    }

    private function autorizarAcesso(User $usuario): void
    {
        $user = auth()->user();
        if (!$user->isSuperadmin() && $usuario->farmacia_id !== $user->farmacia_id) {
            abort(403);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
        'farmacia_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'active'            => 'boolean',
        ];
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminFarmacia(): bool
    {
        return $this->role === 'admin_farmacia';
    }

    public function isFuncionario(): bool
    {
        return $this->role === 'funcionario';
    }

    public function podeGerenciarUsuarios(): bool
    {
        return $this->isSuperadmin() || $this->isAdminFarmacia();
    }

    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class);
    }

    public function processos()
    {
        return $this->hasMany(Processo::class, 'created_by');
    }

    public function recibos()
    {
        return $this->hasMany(Recibo::class, 'gerado_por');
    }
}

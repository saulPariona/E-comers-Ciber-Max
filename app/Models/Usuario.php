<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'IdRol', 'CodigoUsuario', 'TipoDocumento', 'NumeroDocumento', 'Nombres', 'Apellidos',
    'Telefono', 'Fecha_Nacimiento', 'Email', 'email_verified_at', 'Password', 'Google_id',
    'Foto', 'Estado',
])]
#[Hidden(['Password', 'Remember_token', 'Google_id'])]
class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'IdUsuario';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'Fecha_Nacimiento' => 'date:Y-m-d',
            'email_verified_at' => 'datetime',
            'Password' => 'hashed',
            'Estado' => 'boolean',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'Password';
    }

    public function getRememberTokenName(): string
    {
        return 'Remember_token';
    }

    public function getEmailForPasswordReset(): ?string
    {
        return $this->Email;
    }

    public function routeNotificationForMail(): ?string
    {
        return $this->Email;
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'IdRol', 'IdRol');
    }

    public function empleado(): HasOne
    {
        return $this->hasOne(Empleado::class, 'IdUsuario', 'IdUsuario');
    }

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'IdUsuario', 'IdUsuario');
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 'IdUsuario', 'IdUsuario');
    }
}

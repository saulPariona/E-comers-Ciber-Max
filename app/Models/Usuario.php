<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    /**
     * Crea un usuario con rol Cliente y su fila en `clientes`, con código CLI-000123.
     *
     * @param  array<string, mixed>  $datos
     */
    public static function crearCliente(array $datos): self
    {
        return DB::transaction(function () use ($datos) {
            $usuario = self::create([
                ...$datos,
                'IdRol' => Rol::CLIENTE,
                'CodigoUsuario' => 'TMP-'.Str::random(20),
                'Estado' => true,
            ]);

            $usuario->update(['CodigoUsuario' => 'CLI-'.str_pad((string) $usuario->IdUsuario, 6, '0', STR_PAD_LEFT)]);
            Cliente::create(['IdUsuario' => $usuario->IdUsuario]);

            return $usuario;
        });
    }

    public function esEmpleado(): bool
    {
        return in_array($this->IdRol, [
            Rol::ADMINISTRADOR,
            Rol::SUPERVISOR_VENTAS,
            Rol::VENDEDOR,
            Rol::SUPERVISOR_ALMACEN,
            Rol::ALMACENERO,
        ], true);
    }

    /**
     * URL del área a la que pertenece el usuario tras iniciar sesión.
     */
    public function rutaInicio(): string
    {
        return match ($this->IdRol) {
            Rol::ADMINISTRADOR => route('admin.dashboard', absolute: false),
            Rol::SUPERVISOR_VENTAS, Rol::VENDEDOR => route('ventas.dashboard', absolute: false),
            Rol::SUPERVISOR_ALMACEN, Rol::ALMACENERO => route('almacen.dashboard', absolute: false),
            default => route('home', absolute: false),
        };
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

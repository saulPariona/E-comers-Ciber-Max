<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['IdRol', 'Nombre', 'Descripcion', 'Estado'])]
class Rol extends Model
{
    public const ADMINISTRADOR = 1;

    public const SUPERVISOR_VENTAS = 2;

    public const VENDEDOR = 3;

    public const SUPERVISOR_ALMACEN = 4;

    public const ALMACENERO = 5;

    public const CLIENTE = 6;

    protected $table = 'roles';

    protected $primaryKey = 'IdRol';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return ['Estado' => 'boolean'];
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'IdRol', 'IdRol');
    }
}

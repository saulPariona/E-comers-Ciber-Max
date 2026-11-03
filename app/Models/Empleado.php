<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['IdUsuario', 'IdSupervisor', 'Area', 'Turno', 'FechaIngreso'])]
class Empleado extends Model
{
    public const AREA_VENTAS = 'VENTAS';

    public const AREA_ALMACEN = 'ALMACEN';

    protected $table = 'empleados';

    protected $primaryKey = 'IdUsuario';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return ['FechaIngreso' => 'date:Y-m-d'];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(self::class, 'IdSupervisor', 'IdUsuario');
    }

    public function supervisados(): HasMany
    {
        return $this->hasMany(self::class, 'IdSupervisor', 'IdUsuario');
    }
}

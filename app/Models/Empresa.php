<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'IdUsuario', 'IdClienteResponsable', 'Ruc', 'ReferenciaEnvio', 'RazonSocial',
    'EstadoSunat', 'CondicionSunat', 'Validado', 'FechaValidacion',
])]
class Empresa extends Model
{
    protected $table = 'empresas';

    protected $primaryKey = 'IdUsuario';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'Validado' => 'boolean',
            'FechaValidacion' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'IdClienteResponsable', 'IdUsuario');
    }
}

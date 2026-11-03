<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['IdUsuario', 'DireccionEnvio', 'ReferenciaEnvio', 'Ubigeo'])]
class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'IdUsuario';

    public $incrementing = false;

    public $timestamps = false;

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class, 'IdClienteResponsable', 'IdUsuario');
    }
}

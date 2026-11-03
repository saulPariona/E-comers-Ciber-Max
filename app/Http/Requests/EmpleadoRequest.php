<?php

namespace App\Http\Requests;

use App\Models\Empleado;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpleadoRequest extends FormRequest
{
    public function rules(): array
    {
        $actual = $this->route('empleado')?->IdUsuario;
        $req = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'IdUsuario' => $this->isMethod('POST')
                ? ['required', 'integer', 'exists:usuarios,IdUsuario', 'unique:empleados,IdUsuario']
                : ['prohibited'],
            'IdSupervisor' => ['nullable', 'integer', 'exists:empleados,IdUsuario', Rule::notIn([$actual ?? $this->input('IdUsuario')])],
            'Area' => [$req, Rule::in([Empleado::AREA_VENTAS, Empleado::AREA_ALMACEN])],
            'Turno' => [$req, 'string', 'max:30'],
            'FechaIngreso' => [$req, 'date'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolRequest extends FormRequest
{
    public function rules(): array
    {
        $rol = $this->route('rol');
        $sometimes = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'IdRol' => $this->isMethod('POST')
                ? ['required', 'integer', 'min:1', 'unique:roles,IdRol']
                : ['prohibited'],
            'Nombre' => [$sometimes, 'string', 'max:50', Rule::unique('roles', 'Nombre')->ignore($rol?->IdRol, 'IdRol')],
            'Descripcion' => ['nullable', 'string', 'max:255'],
            'Estado' => ['sometimes', 'boolean'],
        ];
    }
}

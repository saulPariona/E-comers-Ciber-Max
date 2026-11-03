<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'TipoDocumento' => ['required', Rule::in(['DNI', 'CE', 'PASAPORTE'])],
            'NumeroDocumento' => ['required', 'integer', 'min:1', 'max:2147483647', 'unique:usuarios,NumeroDocumento'],
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
            'Telefono' => ['nullable', 'string', 'max:20'],
            'Email' => ['required', 'email', 'max:255', 'unique:usuarios,Email'],
            'Password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function attributes(): array
    {
        return [
            'TipoDocumento' => 'tipo de documento',
            'NumeroDocumento' => 'número de documento',
            'Telefono' => 'teléfono',
            'Email' => 'correo electrónico',
            'Password' => 'contraseña',
        ];
    }
}

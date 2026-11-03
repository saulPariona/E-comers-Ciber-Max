<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'IdUsuario' => $this->isMethod('POST')
                ? ['required', 'integer', 'exists:usuarios,IdUsuario', 'unique:clientes,IdUsuario']
                : ['prohibited'],
            'DireccionEnvio' => ['nullable', 'string', 'max:255'],
            'ReferenciaEnvio' => ['nullable', 'string', 'max:255'],
            'Ubigeo' => ['nullable', 'string', 'size:6'],
        ];
    }
}

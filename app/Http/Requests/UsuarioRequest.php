<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('usuario')?->IdUsuario;
        $req = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'IdRol' => [$req, 'integer', Rule::exists('roles', 'IdRol')],
            'CodigoUsuario' => [$req, 'string', 'max:30', Rule::unique('usuarios', 'CodigoUsuario')->ignore($id, 'IdUsuario')],
            'TipoDocumento' => [$req, 'string', 'max:20'],
            'NumeroDocumento' => [$req, 'integer', 'min:1', 'max:2147483647', Rule::unique('usuarios', 'NumeroDocumento')->ignore($id, 'IdUsuario')],
            'Nombres' => [$req, 'string', 'max:255'],
            'Apellidos' => [$req, 'string', 'max:255'],
            'Telefono' => ['nullable', 'string', 'max:20'],
            'Fecha_Nacimiento' => ['nullable', 'date', 'before:today'],
            'Email' => ['nullable', 'email', 'max:255', Rule::unique('usuarios', 'Email')->ignore($id, 'IdUsuario')],
            'Password' => ['nullable', 'string', 'min:8'],
            'Google_id' => ['nullable', 'string', 'max:255'],
            'Foto' => ['nullable', 'string', 'max:255'],
            'Estado' => ['sometimes', 'boolean'],
        ];
    }
}

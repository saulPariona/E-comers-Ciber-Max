<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('empresa')?->IdUsuario;
        $req = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'IdUsuario' => $this->isMethod('POST')
                ? ['required', 'integer', 'exists:usuarios,IdUsuario', 'unique:empresas,IdUsuario']
                : ['prohibited'],
            'IdClienteResponsable' => [$req, 'integer', 'exists:clientes,IdUsuario'],
            'Ruc' => ['nullable', 'digits:11', Rule::unique('empresas', 'Ruc')->ignore($id, 'IdUsuario')],
            'ReferenciaEnvio' => [$req, 'string', 'max:255'],
            'RazonSocial' => [$req, 'string', 'max:255'],
            'EstadoSunat' => [$req, 'string', 'max:50'],
            'CondicionSunat' => [$req, 'string', 'max:50'],
            'Validado' => ['sometimes', 'boolean'],
            'FechaValidacion' => ['nullable', 'date'],
        ];
    }
}

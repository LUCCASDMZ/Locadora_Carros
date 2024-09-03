<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMarcaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => [
                'sometimes',
                'required',
                Rule::unique('marcas')->ignore($this->route('marca')),
            ],
            'imagem' => [
                'sometimes',
                'file',
                'mimes:png',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.unique' => 'Essa marca ja esta registrada',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'imagem.required' => 'O campo imagem é obrigatório',
            'imagem.file' => 'O campo imagem deve ser um arquivo',
            'imagem.mimes' => 'O arquivo de imagem deve ser do tipo PNG',
        ];
    }
}

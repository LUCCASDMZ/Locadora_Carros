<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMarcaRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir que todos os usuários façam a requisição
    }

    public function rules()
    {
        return [
            'nome' => [
                'required',
                'unique:marcas',

            ],
            'imagem' => 'required|file|mimes:png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.unique' => 'Já existe essa marca',
            'imagem.required' => 'O campo imagem é obrigatório',
            'imagem.file' => 'O campo imagem deve ser um arquivo',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo .png',
            'imagem.max' => 'O tamanho máximo do arquivo é 2MB',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erros de validação',
            'errors' => $validator->errors()
        ], 422));
    }
}

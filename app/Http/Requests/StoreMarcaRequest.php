<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'imagem' => 'required|file|mimes:png',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.unique' => 'Já existe essa marca',
            'nome.regex' => 'O campo nome só pode conter letras e espaços',
            'imagem.required' => 'O campo imagem é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo .png',
        ];
    }
}

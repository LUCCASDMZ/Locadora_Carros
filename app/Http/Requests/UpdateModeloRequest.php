<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateModeloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'marca_id' => 'exists:marcas,id',

            'nome' => [
                'sometimes',
                'required',
                Rule::unique('modelos')->ignore($this->route('modelo')),
            ],

            'imagem' => [
                'sometimes',
                'file',
                'mimes:png,jpeg,jpg',
            ],

            'numero_portas' => [
                'sometimes',
                'integer',
                'between:1,5',
            ],

            'lugares' => [
                'sometimes',
                'integer',
                'between:1,20',
            ],

            'air_bag' => [
                'sometimes',
                'boolean',
            ],

            'abs' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function messages()
    {
        return [
            'nome.unique' => 'Esse modelo ja esta registrado',
            'nome.required' => 'O nome e obrigatorio',
            'imagem.required' => 'O campo imagem é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo .png',
        ];
    }
}


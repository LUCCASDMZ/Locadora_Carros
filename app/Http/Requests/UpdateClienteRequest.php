<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nome' => [
                'required',
                ]
        ];
    }

    public function messages()
    {
        return [
            'nome.required'=> 'Escreva um nome'
        ];
    }
}

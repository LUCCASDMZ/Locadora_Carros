<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarroRequest extends FormRequest
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
            'modelo_id' => 'exists:modelos,id',

            'placa' => [
                'sometimes',
            ],

            'disponivel' => [
                'sometimes',
                'boolean',
            ],

            'km' => [
                'sometimes',
            ],
        ];
    }

    public function messages()
    {
        return[
            'modelo_id.exists' => 'Esse modelo nao existe',
        ];
    }
}


<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarroRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required|unique:carros',
            'disponivel' => 'required|boolean',
            'km' => 'required|integer'
        ];
    }

    public function messages()
    {
        return[
            'modelo_id.exists' => 'Esse modelo nao existe',
            'placa.required' => 'É necessario colocar o numero da Placa',
            'placa.unique' => 'Este numero de placa ja foi registrado',
            'disponivel.required' => 'É necessario especificar se está disponivel ou não',
            'ikm.required' => 'Coloque a Km do Carro',
        ];
    }
}

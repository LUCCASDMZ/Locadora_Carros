<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocacaoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required|date',
            'data_final_previsto_periodo' => 'required|date|after_or_equal:data_inicio_periodo',
            //'data_final_realizado_periodo' => 'date|after_or_equal:data_inicio_periodo',
            'valor_diaria' => 'required|integer|min:0',
            'km_inicial' => 'required|numeric|',
            //'km_final' => 'numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não é válido.',
            'carro_id.required' => 'O carro é obrigatório.',
            'carro_id.exists' => 'O carro selecionado não é válido.',
            'data_inicio_periodo.required' => 'A data de início é obrigatória.',
            'data_inicio_periodo.date' => 'A data de início deve ser uma data válida.',
            'data_final_previsto_periodo.required' => 'A data final prevista é obrigatória.',
            'data_final_previsto_periodo.date' => 'A data final prevista deve ser uma data válida.',
            'data_final_previsto_periodo.after_or_equal' => 'A data final prevista deve ser posterior ou igual à data de início.',
            'data_final_realizado_periodo.required' => 'A data final realizada é obrigatória.',
            'data_final_realizado_periodo.date' => 'A data final realizada deve ser uma data válida.',
            'data_final_realizado_periodo.after_or_equal' => 'A data final realizada deve ser posterior ou igual à data de início.',
            'valor_diaria.required' => 'O valor da diária é obrigatório.',
            'valor_diaria.integer' => 'O valor da diária deve ser um número inteiro.',
            'valor_diaria.min' => 'O valor da diária deve ser no mínimo 0.',
            'km_inicial.required' => 'A quilometragem inicial é obrigatória.',
            'km_inicial.integer' => 'A quilometragem inicial deve ser um número inteiro.',
            'km_inicial.min' => 'A quilometragem inicial deve ser no mínimo 0.',
            'km_final.required' => 'A quilometragem final é obrigatória.',
            'km_final.integer' => 'A quilometragem final deve ser um número inteiro.',
            'km_final.min' => 'A quilometragem final deve ser maior ou igual à quilometragem inicial.',
        ];
    }
}


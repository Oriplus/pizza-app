<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaRequest extends FormRequest
{
     /**
     * General validation rules for pizza requests.
     *
     * @return array
     */
    protected function generalRules(): array
    {
        return [
            'selling_price' => 'required|numeric',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id',
        ];
    }
}

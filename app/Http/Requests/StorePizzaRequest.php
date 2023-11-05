<?php

namespace App\Http\Requests;

class StorePizzaRequest extends PizzaRequest
{
    /**
     * Validation rules for store pizza.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::generalRules(), [
            'name' => 'required|string',
        ]);
    }
}

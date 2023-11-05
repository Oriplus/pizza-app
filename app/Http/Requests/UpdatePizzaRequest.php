<?php

namespace App\Http\Requests;

class UpdatePizzaRequest extends PizzaRequest
{
    /**
     * Validation rules for update pizza.
     *
     * @return array
     */
    public function rules(): array
    {
        return parent::generalRules();
    }
}

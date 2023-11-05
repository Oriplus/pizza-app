<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePizzaRequest extends FormRequest
{
    /**
     * Validation rules for store pizza.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::commonRules(), [
            'name' => 'required|string',
        ]);
    }
}

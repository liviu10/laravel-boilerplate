<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;

trait NameValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, Rule|array|string>
     */
    protected function nameRules(): array
    {
        return [
            'required',
            'string',
            'min:3',
            'max:100',
            'regex:/^[a-zA-Z\s]+$/'
        ];
    }
}

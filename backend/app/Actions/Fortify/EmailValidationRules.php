<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;

trait EmailValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, Rule|array|string>
     */
    protected function emailRules(): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users'
        ];
    }
}

<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;

trait PhoneValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, Rule|array|string>
     */
    protected function phoneRules(): array
    {
        return [
            'required',
            'string',
            'min:7',
            'max:15',
            'regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/'
        ];
    }
}

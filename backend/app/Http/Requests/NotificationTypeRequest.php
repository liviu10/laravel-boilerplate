<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    static function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The first name field is required.',
            'name.string' => 'The first name must be a string.',
            'name.min' => 'The first name must be at least :min characters.',
            'name.max' => 'The first name may not be greater than :max characters.',
            'name.regex' => 'The first name field must only contain letters and spaces.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContentTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    public function rules(): array
    {
        $currentRouteName = Route::current()->getName();
        $rules = [];

        if ($currentRouteName === 'types.store') {
            $rules = [
                'value' => 'required|string',
                'label' => 'required|string',
                'is_active' => 'required|boolean',
            ];
        }

        if ($currentRouteName === 'types.update') {
            $rules = [
                'value' => 'sometimes|string',
                'label' => 'sometimes|string',
                'is_active' => 'sometimes|boolean',
            ];
        }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'value.required' => 'The value field is required.',
            'value.string' => 'The value must be a string.',
            'label.required' => 'The label field is required.',
            'label.string' => 'The label must be a string.',
            'is_active.required' => 'The is active field is required.',
            'is_active.boolean' => 'The is active field must be a boolean value.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

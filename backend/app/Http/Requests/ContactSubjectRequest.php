<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContactSubjectRequest extends FormRequest
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

        if ($currentRouteName === 'subjects.store') {
            $rules = [
                'value' => 'required|string',
                'label' => 'required|string',
                'is_active' => 'required|boolean',
            ];
        }

        if ($currentRouteName === 'subjects.update') {
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
            'is_active.required' => 'The privacy policy field is required.',
            'is_active.boolean' => 'The privacy policy field must be a boolean value.',
        ];
    }
}

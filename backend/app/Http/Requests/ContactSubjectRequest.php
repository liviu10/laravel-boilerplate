<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'value' => 'required|integer',
            'label' => 'required|string',
            'privacy_policy' => 'required|boolean',
            'user_id' => 'required|integer',
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
            'value.required' => 'The value field is required.',
            'value.integer' => 'The value must be an integer.',
            'label.required' => 'The label field is required.',
            'label.string' => 'The label must be a string.',
            'privacy_policy.required' => 'The privacy policy field is required.',
            'privacy_policy.boolean' => 'The privacy policy field must be a boolean value.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

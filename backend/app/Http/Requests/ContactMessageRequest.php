<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'contact_subject_id' => 'required|integer',
            'full_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string',
            'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
            'message' => 'required|string',
            'privacy_policy' => 'required|boolean',
            'user_id' => 'sometimes|integer',
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
            'contact_subject_id.required' => 'The contact subject ID field is required.',
            'contact_subject_id.integer' => 'The contact subject ID must be an integer.',
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'full_name.regex' => 'The full name must contain only letters and spaces.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'phone.string' => 'The phone must be a string.',
            'phone.min' => 'The phone must be at least :min characters.',
            'phone.max' => 'The phone may not be greater than :max characters.',
            'phone.regex' => 'The phone must be a valid phone number.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'privacy_policy.required' => 'The privacy policy field is required.',
            'privacy_policy.boolean' => 'The privacy policy field must be a boolean value.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

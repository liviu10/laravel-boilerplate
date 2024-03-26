<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactResponseRequest extends FormRequest
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
            'contact_message_id' => 'required|integer',
            'message' => 'required|string',
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
            'contact_message_id.required' => 'The contact message ID field is required.',
            'contact_message_id.integer' => 'The contact message ID must be an integer.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

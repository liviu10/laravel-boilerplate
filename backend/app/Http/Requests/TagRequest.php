<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'content_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'sometimes|string',
            'slug' => 'required|string',
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
            'content_id.required' => 'The content ID field is required.',
            'content_id.integer' => 'The content ID must be an integer.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'description.string' => 'The description must be a string.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug must be a string.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

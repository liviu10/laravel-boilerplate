<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            'content_visibility_id' => 'required|integer',
            'content_url' => 'required|string',
            'title' => 'required|string|min:3|max:255',
            'content_type_id' => 'required|integer',
            'description' => 'sometimes|string',
            'content' => 'required|string',
            'allow_comments' => 'required|boolean',
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
            'content_visibility_id.required' => 'The content visibility ID field is required.',
            'content_visibility_id.integer' => 'The content visibility ID must be an integer.',
            'content_url.required' => 'The content URL field is required.',
            'content_url.string' => 'The content URL must be a string.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'content_type_id.required' => 'The content type ID field is required.',
            'content_type_id.integer' => 'The content type ID must be an integer.',
            'description.string' => 'The description must be a string.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'allow_comments.required' => 'The allow comments field is required.',
            'allow_comments.boolean' => 'The allow comments field must be a boolean value.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

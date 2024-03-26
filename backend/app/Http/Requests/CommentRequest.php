<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment_type_id' => 'required|integer',
            'comment_statuses_id' => 'required|integer',
            'content_id' => 'required|integer',
            'full_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'message' => 'required|string',
            'notify_new_comments' => 'required|boolean',
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
            'comment_type_id.required' => 'The comment type ID field is required.',
            'comment_type_id.integer' => 'The comment type ID must be an integer.',
            'comment_statuses_id.required' => 'The comment status ID field is required.',
            'comment_statuses_id.integer' => 'The comment status ID must be an integer.',
            'content_id.required' => 'The content ID field is required.',
            'content_id.integer' => 'The content ID must be an integer.',
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'full_name.regex' => 'The full name must contain only letters and spaces.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'notify_new_comments.required' => 'The notify new comments field is required.',
            'notify_new_comments.boolean' => 'The notify new comments field must be a boolean value.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

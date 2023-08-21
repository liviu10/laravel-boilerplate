<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'status' => [
                'sometimes',
                'string',
                Rule::in(['Pending', 'Approved', 'Spam', 'Trash'])
            ],
            'full_name' => 'required|string|min:5|max:255',
            'email' => 'sometimes|string|min:3|max:255',
            'message' => 'required|string|min:5|max:255',
            'notify_new_comments' => 'required',
        ];

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'email.required' => 'The email address field is required.',
            'email.string' => 'The email address must be a string.',
            'email.min' => 'The email address must be at least :min characters.',
            'email.max' => 'The email address may not be greater than :max characters.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'message.min' => 'The message must be at least :min characters.',
            'message.max' => 'The message may not be greater than :max characters.',
            'notify_new_comments.required' => 'The notify new comments is required.',
        ];
    }
}

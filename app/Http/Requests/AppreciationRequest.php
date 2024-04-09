<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppreciationRequest extends FormRequest
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
            'content_id' => 'required|integer',
            'likes' => 'sometimes|integer|min:0',
            'dislikes' => 'sometimes|integer|min:0',
            'rating' => 'sometimes|integer|min:0|max:10',
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
            'user_id.integer' => 'The user ID must be an integer.',
            'likes.integer' => 'Likes must be an integer.',
            'likes.min' => 'Likes cannot be negative.',
            'dislikes.integer' => 'Dislikes must be an integer.',
            'dislikes.min' => 'Dislikes cannot be negative.',
            'rating.integer' => 'Rating must be an integer.',
            'rating.min' => 'Rating cannot be less than 0.',
            'rating.max' => 'Rating cannot be greater than 10.',
        ];
    }
}

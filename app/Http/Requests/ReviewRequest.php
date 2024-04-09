<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ReviewRequest extends FormRequest
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

        if ($currentRouteName === 'review') {
            $rules = [
                'full_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'rating' => 'required|integer|min:0|max:10',
                'comment' => 'sometimes|string',
            ];
        }

        if ($currentRouteName === 'reviews.update') {
            $rules = [
                'is_active' => 'required|boolean',
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
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'full_name.regex' => 'The full name must contain only letters and spaces.',
            'rating.required' => 'The rating field is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.min' => 'The rating must be at least :min.',
            'rating.max' => 'The rating may not be greater than :max.',
            'comment.string' => 'The comment must be a string.',
            'is_active.required' => 'The is active field is required.',
            'is_active.boolean' => 'The is active field must be a boolean value.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AcceptedDomainRequest extends FormRequest
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
    static function rules()
    {
        $currentRouteName = Route::current()->getName();
        $rules = [];

        // Validation rules when creating
        if ($currentRouteName === 'review.store')
        {
            $rules = [
                'full_name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'rating'    => 'required|integer|min:0|max:5',
                'comment'   => 'required|string|min:5|max:255',
                'is_active' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'reviews.update')
        {
            $rules = [
                'is_active' => 'required',
            ];
        }

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
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'full_name.regex' => 'The full name can only contain letters and spaces.',
            'rating.required' => 'The rating field is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.min' => 'The rating must be at least :min.',
            'rating.max' => 'The rating may not be greater than :max.',
            'comment.required' => 'The comment field is required.',
            'comment.string' => 'The comment must be a string.',
            'comment.min' => 'The comment must be at least :min characters.',
            'comment.max' => 'The comment may not be greater than :max characters.',
            'is_active.required' => 'The is active field is required.',
        ];
    }
}

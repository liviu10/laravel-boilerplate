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
        $rules = [
            'likes' => 'sometimes|integer',
            'dislikes' => 'sometimes|integer',
            'rating' => 'sometimes|integer|min:0|max:5',
            'content_id' => 'required',
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
            'likes.required' => 'The likes field is required.',
            'likes.integer' => 'The likes must be integer.',
            'dislikes.required' => 'The dislikes field is required.',
            'dislikes.integer' => 'The dislikes must be integer.',
            'rating.required' => 'The rating field is required.',
            'rating.integer' => 'The rating must be integer.',
            'rating.min' => 'The rating must be at least :min.',
            'rating.max' => 'The rating may not be greater than :max.',
        ];
    }
}

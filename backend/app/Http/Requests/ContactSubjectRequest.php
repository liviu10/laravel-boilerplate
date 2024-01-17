<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContactSubjectRequest extends FormRequest
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
        if ($currentRouteName === 'subjects.store') {
            $rules = [
                'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'description' => 'sometimes|string|min:3|max:255',
                'is_active' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'subjects.update') {
            $rules = [
                'name' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'description' => 'sometimes|string|min:3|max:255',
                'is_active' => 'sometimes',
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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'name.regex' => 'The name may only contain letters and spaces.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'is_active.required' => 'You must activate this.',
        ];
    }
}

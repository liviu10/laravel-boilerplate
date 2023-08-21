<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class TagRequest extends FormRequest
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
        $currentRouteName = Route::current()->getName();

        // Validation rules when creating
        if ($currentRouteName === 'tags.store')
        {
            $rules = [
                'name' => 'required|string|min:3|max:255',
                'description' => 'sometimes|string|min:10|max:255',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'tags.update')
        {
            $rules = [
                'name' => 'sometimes|string|min:3|max:255',
                'description' => 'sometimes|string|min:10|max:255',
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
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
        ];
    }
}

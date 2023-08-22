<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RoleRequest extends FormRequest
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
        $rules = [];

        // Validation rules when creating
        if ($currentRouteName === 'roles.store')
        {
            $rules = [
                'name'        => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'description' => 'required|string|min:10|max:255',
                'slug'        => 'required|string|min:3|max:100',
                'bg_color'    => 'sometimes|string|min:3|max:6|regex:/^[a-zA-Z0-9]+$/',
                'text_color'  => 'sometimes|string|min:3|max:6|regex:/^[a-zA-Z0-9]+$/',
                'is_active'   => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'roles.update')
        {
            $rules = [
                'name'        => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'description' => 'sometimes|string|min:10|max:255',
                'slug'        => 'sometimes|string|min:3|max:100',
                'bg_color'    => 'sometimes|string|min:3|max:6|regex:/^[a-zA-Z0-9]+$/',
                'text_color'  => 'sometimes|string|min:3|max:6|regex:/^[a-zA-Z0-9]+$/',
                'is_active'   => 'sometimes',
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
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.min' => 'The slug must be at least :min characters.',
            'slug.max' => 'The slug may not be greater than :max characters.',
            'bg_color.string' => 'The background color must be a string.',
            'bg_color.min' => 'The background color must be at least :min characters.',
            'bg_color.max' => 'The background color may not be greater than :max characters.',
            'bg_color.regex' => 'The background color may only contain letters and digits.',
            'text_color.string' => 'The text color must be a string.',
            'text_color.min' => 'The text color must be at least :min characters.',
            'text_color.max' => 'The text color may not be greater than :max characters.',
            'text_color.regex' => 'The text color may only contain letters and digits.',
            'is_active.required' => 'The is active field is required.',
        ];
    }
}

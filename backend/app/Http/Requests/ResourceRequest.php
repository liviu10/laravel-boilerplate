<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class ResourceRequest extends FormRequest
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
        if ($currentRouteName === 'resources.store')
        {
            $rules = [
                'type' => [
                    'required',
                    'string',
                    Rule::in(['Menu', 'API'])
                ],
                'path' => 'required|string|min:3|max:255',
                'name' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'component' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'layout' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'title' => 'sometimes|string|min:3|max:100',
                'caption' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s.]+$/',
                'icon' => 'sometimes|string|min:1|max:100|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'required',
                'requires_auth' => 'required',
                'position' => 'sometimes|integer',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'resources.update')
        {
            $rules = [
                'type' => [
                    'sometimes',
                    'string',
                    Rule::in(['Menu', 'API'])
                ],
                'path' => 'sometimes|string|min:3|max:255',
                'name' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'component' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'layout' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'title' => 'sometimes|string|min:3|max:100',
                'caption' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s.]+$/',
                'icon' => 'sometimes|string|min:1|max:100|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'sometimes',
                'requires_auth' => 'sometimes',
                'position' => 'sometimes|integer',
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
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'type.in' => 'The selected type is invalid.',
            'path.required' => 'The path field is required.',
            'path.string' => 'The path must be a string.',
            'path.min' => 'The path must be at least :min characters.',
            'path.max' => 'The path may not be greater than :max characters.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'name.regex' => 'The name field must only contain letters and spaces.',
            'component.string' => 'The component must be a string.',
            'component.min' => 'The component must be at least :min characters.',
            'component.max' => 'The component may not be greater than :max characters.',
            'component.regex' => 'The component field must only contain letters and spaces.',
            'layout.string' => 'The layout must be a string.',
            'layout.min' => 'The layout must be at least :min characters.',
            'layout.max' => 'The layout may not be greater than :max characters.',
            'layout.regex' => 'The layout field must only contain letters and spaces.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'caption.string' => 'The caption must be a string.',
            'caption.min' => 'The caption must be at least :min characters.',
            'caption.max' => 'The caption may not be greater than :max characters.',
            'caption.regex' => 'The caption field must only contain letters, spaces, and dots.',
            'icon.string' => 'The icon must be a string.',
            'icon.min' => 'The icon must be at least :min characters.',
            'icon.max' => 'The icon may not be greater than :max characters.',
            'icon.regex' => 'The icon field must only contain letters and spaces.',
            'is_active.required' => 'The is active field is required.',
            'requires_auth.required' => 'The requires authentication field is required.',
            'position.integer' => 'The position must be an integer.',
        ];
    }
}

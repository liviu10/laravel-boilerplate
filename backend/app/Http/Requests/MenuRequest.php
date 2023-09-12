<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class MenuRequest extends FormRequest
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
        if ($currentRouteName === 'application-menus.store')
        {
            $rules = [
                'path' => 'required|string|min:3|max:255',
                'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'title' => 'required|string|min:3|max:100',
                'caption' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'icon' => 'required|string|min:1|max:100|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'required',
                'requires_auth' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'application-menus.update')
        {
            $rules = [
                'path' => 'sometimes|string|min:3|max:255',
                'name' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'title' => 'sometimes|string|min:3|max:100',
                'caption' => 'sometimes|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'icon' => 'sometimes|string|min:1|max:100|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'sometimes',
                'requires_auth' => 'sometimes',
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
            'path.required' => 'The path field is required.',
            'path.string' => 'The path must be a string.',
            'path.min' => 'The path must be at least :min characters.',
            'path.max' => 'The path may not be greater than :max characters.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'name.regex' => 'The name field may only contain letters and spaces.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'caption.required' => 'The caption field is required.',
            'caption.string' => 'The caption must be a string.',
            'caption.min' => 'The caption must be at least :min characters.',
            'caption.max' => 'The caption may not be greater than :max characters.',
            'caption.regex' => 'The caption field may only contain letters and spaces.',
            'icon.required' => 'The icon field is required.',
            'icon.string' => 'The icon must be a string.',
            'icon.min' => 'The icon must be at least :min characters.',
            'icon.max' => 'The icon may not be greater than :max characters.',
            'icon.regex' => 'The icon field may only contain letters and spaces.',
            'is_active.required' => 'The is active field is required.',
            'requires_auth.required' => 'The requires authentication field is required.',
        ];
    }
}

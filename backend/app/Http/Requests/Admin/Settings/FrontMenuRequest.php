<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class FrontMenuRequest extends FormRequest
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
            'path'      => 'required|string|regex:/^[a-z0-9\/-]+$/',
            'name'      => 'sometimes|string|regex:/^[a-zA-Z]+$/',
            'title'     => 'sometimes|string',
            'caption'   => 'sometimes|string',
            'icon'      => 'sometimes|string',
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
            'path.required' => 'The path field is required.',
            'path.string' => 'The path field must be a string.',
            'path.regex' => 'The path must only contain lowercase letters, numbers, forward slashes, and hyphens.',
            'name.string' => 'The name field must be a string.',
            'name.regex' => 'The name field must only contain letters.',
            'title.string' => 'The title field must be a string.',
            'caption.string' => 'The caption field must be a string.',
            'icon.string' => 'The icon field must be a string.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneralRequest extends FormRequest
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
            'type' => [
                'required',
                'string',
                Rule::in([
                    'General',
                    'Writing',
                    'Reading',
                    'Discussion',
                    'Media',
                    'Performance',
                    'Notifications',
                ])
            ],
            'label' => 'required|string|min:3|max:50',
            'value' => 'required|string|min:3|max:255',
        ];

        if ($this->isMethod('PUT')) {
            $rules = array_map(function ($rule) {
                return str_replace('required|', 'sometimes|', $rule);
            }, $rules);
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
            'label.required' => 'The label field is required.',
            'label.string' => 'The label must be a string.',
            'label.min' => 'The label must be at least :min characters.',
            'label.max' => 'The label may not be greater than :max characters.',
            'value.required' => 'The value field is required.',
            'value.string' => 'The value must be a string.',
            'value.min' => 'The value must be at least :min characters.',
            'value.max' => 'The value may not be greater than :max characters.',
        ];
    }
}

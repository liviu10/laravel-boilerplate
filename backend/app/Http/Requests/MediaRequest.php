<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class MediaRequest extends FormRequest
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
        if ($currentRouteName === 'general.store')
        {
            $rules = [
                'type' => [
                    'required',
                    'string',
                    Rule::in(['Images', 'Documents', 'Videos', 'Audio', 'Others'])
                ],
                'internal_path' => 'required|string|min:10|max:255',
                'external_path' => 'required|string|min:10|max:255',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'media.update')
        {
            $rules = [
                'type' => [
                    'sometimes',
                    'string',
                    Rule::in(['Images', 'Documents', 'Videos', 'Audio', 'Others'])
                ],
                'internal_path' => 'sometimes|string|min:10|max:255',
                'external_path' => 'sometimes|string|min:10|max:255',
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
            'internal_path.required' => 'The internal path field is required.',
            'internal_path.string' => 'The internal path must be a string.',
            'internal_path.min' => 'The internal path must be at least :min characters.',
            'internal_path.max' => 'The internal path may not be greater than :max characters.',
            'external_path.required' => 'The external path field is required.',
            'external_path.string' => 'The external path must be a string.',
            'external_path.min' => 'The external path must be at least :min characters.',
            'external_path.max' => 'The external path may not be greater than :max characters.',
        ];
    }
}

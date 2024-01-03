<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ConfigurationColumnRequest extends FormRequest
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
        if ($currentRouteName === 'columns.store')
        {
            $rules = [
                'align' => 'required|string',
                'field' => 'required|string',
                'header_style' => 'required|string',
                'label' => 'required|string',
                'name' => 'required|string',
                'position' => 'required|integer',
                'style' => 'required|string',
                'configuration_resource_id' => 'required',
                'configuration_type_id' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'columns.update')
        {
            $rules = [
                'align' => 'sometimes|string',
                'field' => 'sometimes|string',
                'header_style' => 'sometimes|string',
                'label' => 'sometimes|string',
                'name' => 'sometimes|string',
                'position' => 'sometimes|integer',
                'style' => 'sometimes|string',
                'configuration_resource_id' => 'sometimes',
                'configuration_type_id' => 'sometimes',
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
            'align.required' => 'The alignment field is required.',
            'align.string' => 'The alignment must be a string.',
            'field.required' => 'The field field is required.',
            'field.string' => 'The field must be a string.',
            'header_style.required' => 'The header style field is required.',
            'header_style.string' => 'The header style must be a string.',
            'label.required' => 'The label field is required.',
            'label.string' => 'The label must be a string.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'position.required' => 'The position field is required.',
            'position.integer' => 'The position must be an integer.',
            'style.required' => 'The style field is required.',
            'style.string' => 'The style must be a string.',
            'configuration_resource_id.required' => 'The configuration resource ID field is required.',
            'configuration_type_id.required' => 'The configuration type ID field is required.',
        ];
    }
}

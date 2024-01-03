<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ConfigurationTypeRequest extends FormRequest
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
        if ($currentRouteName === 'types.store') {
            $rules = [
                'name' => 'required|string',
                'is_active' => 'required',
                'configuration_resource_id' => 'required|integer',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'types.update') {
            $rules = [
                'name' => 'sometimes|string',
                'is_active' => 'sometimes',
                'configuration_resource_id' => 'sometimes|integer',
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
            'is_active.required' => 'The is_active field is required.',
            'configuration_resource_id.required' => 'The configuration resource ID field is required.',
            'configuration_resource_id.integer' => 'The configuration resource ID must be an integer.',
        ];
    }
}

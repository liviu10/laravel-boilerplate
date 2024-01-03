<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ConfigurationInputRequest extends FormRequest
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
        if ($currentRouteName === 'inputs.store') {
            $rules = [
                'accept' => 'required|string',
                'field' => 'required|string',
                'is_active' => 'required',
                'is_filter' => 'required',
                'is_model' => 'required',
                'key' => 'required|string',
                'name' => 'required|string',
                'position' => 'required|integer',
                'type' => 'required|in:number,textarea,time,text,password,email,search,tel,file,url,date',
                'configuration_resource_id' => 'required',
                'configuration_type_id' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'inputs.update') {
            $rules = [
                'accept' => 'sometimes|string',
                'field' => 'sometimes|string',
                'is_active' => 'sometimes',
                'is_filter' => 'sometimes',
                'is_model' => 'sometimes',
                'key' => 'sometimes|string',
                'name' => 'sometimes|string',
                'position' => 'sometimes|integer',
                'type' => 'sometimes|in:number,textarea,time,text,password,email,search,tel,file,url,date',
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
     */ public function messages()
    {
        return [
            'accept.required' => 'The accept field is required.',
            'accept.string' => 'The accept must be a string.',
            'field.required' => 'The field field is required.',
            'field.string' => 'The field must be a string.',
            'is_active.required' => 'The is_active field is required.',
            'is_filter.required' => 'The is_filter field is required.',
            'is_model.required' => 'The is_model field is required.',
            'key.required' => 'The key field is required.',
            'key.string' => 'The key must be a string.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'position.required' => 'The position field is required.',
            'position.integer' => 'The position must be an integer.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid. Please choose a valid type.',
            'configuration_resource_id.required' => 'The configuration resource ID field is required.',
            'configuration_type_id.required' => 'The configuration type ID field is required.',
        ];
    }
}

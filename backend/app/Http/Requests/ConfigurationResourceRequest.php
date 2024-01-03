<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ConfigurationResourceRequest extends FormRequest
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
                'resource' => 'required|string',
                'key'      => 'required|string',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'resources.update')
        {
            $rules = [
                'resource' => 'sometimes|string',
                'key'      => 'sometimes|string',
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
            'resource.required' => 'The domain field is required.',
            'resource.string' => 'The domain must be a string.',
            'key.required' => 'The key field is required.',
            'key.string' => 'The key must be a string.',
        ];
    }
}

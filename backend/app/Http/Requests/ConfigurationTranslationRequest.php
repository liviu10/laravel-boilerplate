<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ConfigurationTranslationRequest extends FormRequest
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
        if ($currentRouteName === 'translations.store')
        {
            $rules = [
                'key' => 'required|string',
                'translation' => 'required|string',
                'related_model_name' => 'required|string',
                'related_model_id' => 'required|integer',
                'configuration_translation_locale_id' => 'required|integer',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'translations.update')
        {
            $rules = [
                'key' => 'sometimes|string',
                'translation' => 'sometimes|string',
                'related_model_name' => 'sometimes|string',
                'related_model_id' => 'sometimes|integer',
                'configuration_translation_locale_id' => 'sometimes|integer',
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
            'key.required' => 'The key field is required.',
            'key.string' => 'The key must be a string.',
            'translation.required' => 'The translation field is required.',
            'translation.string' => 'The translation must be a string.',
            'related_model_name.required' => 'The related model name field is required.',
            'related_model_name.string' => 'The related model name must be a string.',
            'related_model_id.required' => 'The related model ID field is required.',
            'related_model_id.integer' => 'The related model ID must be an integer.',
            'configuration_translation_locale_id.required' => 'The configuration translation locale ID field is required.',
            'configuration_translation_locale_id.integer' => 'The configuration translation locale ID must be an integer.',
        ];
    }
}

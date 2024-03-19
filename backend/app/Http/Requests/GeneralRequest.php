<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class GeneralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    static function rules(): array
    {
        $currentRouteName = Route::current()->getName();
        $rules = [];

        // Validation rules when creating
        if ($currentRouteName === 'general.store')
        {
            $rules = [
                'generalable_id' => 'required|integer',
                'generalable_type' => 'required|string',
                'value' => 'required|string|min:1|max:255',
                'label' => 'required|string|min:3|max:255',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'general.update')
        {
            $rules = [
                'generalable_id' => 'sometimes|integer',
                'generalable_type' => 'sometimes|string',
                'value' => 'sometimes|string|min:1|max:255',
                'label' => 'sometimes|string|min:3|max:255',
            ];
        }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'generalable_id.required' => 'The generalable ID is required.',
            'generalable_id.integer' => 'The generalable ID must be an integer.',
            'generalable_type.required' => 'The generalable type is required.',
            'generalable_type.string' => 'The generalable type must be a string.',
            'value.required' => 'The value is required.',
            'value.string' => 'The value must be a string.',
            'value.min' => 'The value must be at least :min characters.',
            'value.max' => 'The value may not be greater than :max characters.',
            'label.required' => 'The label is required.',
            'label.string' => 'The label must be a string.',
            'label.min' => 'The label must be at least :min characters.',
            'label.max' => 'The label may not be greater than :max characters.',
        ];
    }
}

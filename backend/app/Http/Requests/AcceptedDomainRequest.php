<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AcceptedDomainRequest extends FormRequest
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
        $currentRouteName = Route::current()->getName();

        // Validation rules when creating
        if ($currentRouteName === 'accepted-domains.store')
        {
            $rules = [
                'domain' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/|regex:/^[a-z]+$/|unique:accepted_domains',
                'type' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'accepted-domains.update')
        {
            $rules = [
                'domain' => 'sometimes|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/|regex:/^[a-z]+$/|unique:accepted_domains',
                'type' => 'sometimes|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
                'is_active' => 'sometimes',
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
            'domain.required' => 'The domain field is required.',
            'domain.string' => 'The domain must be a string.',
            'domain.min' => 'The domain must be at least :min characters.',
            'domain.max' => 'The domain may not be greater than :max characters.',
            'domain.regex' => 'The domain may only contain letters and spaces.',
            'domain.regex' => 'The domain must start with a lowercase letter.',
            'domain.unique' => 'The domain has already been accepted.',
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'type.min' => 'The type must be at least :min characters.',
            'type.max' => 'The type may not be greater than :max characters.',
            'type.regex' => 'The type may only contain letters and spaces.',
            'is_active.required' => 'The is_active field is required.',
        ];
    }
}

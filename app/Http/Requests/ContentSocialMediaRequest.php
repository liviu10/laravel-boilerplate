<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContentSocialMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    public function rules(): array
    {
        $currentRouteName = Route::current()->getName();
        $rules = [];

        if ($currentRouteName === 'contents.store') {
            $rules = [
                'content_id' => 'required|integer',
                'platform_name' => 'required|string|min:3|max:255',
                'platform_share_url' => 'required|string|min:3|max:255',
                'full_share_url' => 'required|string|min:3|max:255',
            ];
        }

        if ($currentRouteName === 'contents.update') {
            $rules = [
                'content_id' => 'sometimes|integer',
                'platform_name' => 'sometimes|string|min:3|max:255',
                'platform_share_url' => 'sometimes|string|min:3|max:255',
                'full_share_url' => 'sometimes|string|min:3|max:255',
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
            'content_id.required' => 'The content ID is required.',
            'content_id.integer' => 'The content ID must be an integer.',
            'platform_name.required' => 'The platform name is required.',
            'platform_name.string' => 'The platform name must be a string.',
            'platform_name.min' => 'The platform name must be at least :min characters.',
            'platform_name.max' => 'The platform name may not be greater than :max characters.',
            'platform_share_url.required' => 'The platform share URL is required.',
            'platform_share_url.string' => 'The platform share URL must be a string.',
            'platform_share_url.min' => 'The platform share URL must be at least :min characters.',
            'platform_share_url.max' => 'The platform share URL may not be greater than :max characters.',
            'full_share_url.required' => 'The full share URL is required.',
            'full_share_url.string' => 'The full share URL must be a string.',
            'full_share_url.min' => 'The full share URL must be at least :min characters.',
            'full_share_url.max' => 'The full share URL may not be greater than :max characters.',
        ];
    }
}

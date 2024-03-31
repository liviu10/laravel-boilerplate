<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class NewsletterSubscriberRequest extends FormRequest
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

        if ($currentRouteName === 'subscribers.store') {
            $rules = [
                'newsletter_campaign_id' => 'required|integer',
                'full_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|string|unique:newsletter_subscribers',
                'privacy_policy' => 'required|boolean',
                'valid_email' => 'sometimes|boolean',
            ];
        }

        if ($currentRouteName === 'subscribers.update') {
            $rules = [
                'newsletter_campaign_id' => 'required|integer',
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
            'newsletter_campaign_id.required' => 'The newsletter campaign ID field is required.',
            'newsletter_campaign_id.integer' => 'The newsletter campaign ID must be an integer.',
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'full_name.regex' => 'The full name must contain only letters and spaces.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.unique' => 'The email has already been taken.',
            'privacy_policy.required' => 'The privacy policy field is required.',
            'privacy_policy.boolean' => 'The privacy policy field must be a boolean value.',
            'valid_email.boolean' => 'The valid email field must be a boolean value.',
        ];
    }
}

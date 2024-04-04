<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

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

        if ($currentRouteName === 'subscribers.store' || $currentRouteName === 'newsletter.subscribe') {
            $rules = [
                'newsletter_campaign_id' => 'required|array',
                'full_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'email' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                    Rule::unique('newsletter_subscribers')->where(function ($query) {
                        return $query->where('newsletter_campaign_id', $this->input('newsletter_campaign_id'));
                    }),
                ],
                'privacy_policy' => 'required|boolean',
                'valid_email' => 'sometimes|boolean',
            ];
        }

        if ($currentRouteName === 'subscribers.update') {
            $rules = [
                'newsletter_campaign_id' => 'required|array',
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
            'email.min' => 'The email must be at least :min characters.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.regex' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been subscribed to this newsletter campaign.',
            'privacy_policy.required' => 'The privacy policy field is required.',
            'privacy_policy.boolean' => 'The privacy policy field must be a boolean value.',
            'valid_email.boolean' => 'The valid email field must be a boolean value.',
        ];
    }
}

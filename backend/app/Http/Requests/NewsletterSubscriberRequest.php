<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class NewsletterSubscriberRequest extends FormRequest
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

        // Validation rules when user is subscribing to the newsletter
        if ($currentRouteName === 'subscribes.store' || $currentRouteName === 'newsletter.subscribe')
        {
            $rules = [
                'full_name' => 'required|string|min:3|max:255',
                'email' => 'required|string|min:3|max:255|unique:newsletter_subscribers',
                'privacy_policy' => 'sometimes',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'subscribers.update')
        {
            $rules = [
                'newsletter_campaign_id' => 'required',
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
            'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.min' => 'The full name must be at least :min characters.',
            'full_name.max' => 'The full name may not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.min' => 'The email must be at least :min characters.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.unique' => 'The email has already been taken.',
            'privacy_policy.required' => 'The privacy policy field is required.',
        ];
    }
}

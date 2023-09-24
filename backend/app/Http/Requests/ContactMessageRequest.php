<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContactMessageRequest extends FormRequest
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
        if ($currentRouteName === 'messages.store') {
            $rules = [
                'full_name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|string|min:3|max:255',
                'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
                'contact_subject_id' => 'required',
                'message' => 'required|string|min:3|max:255',
                'privacy_policy' => 'sometimes',
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
            'full_name.regex' => 'The full name may only contain letters and spaces.',
            'email.required' => 'The email address field is required.',
            'email.string' => 'The email address must be a string.',
            'email.min' => 'The email address must be at least :min characters.',
            'email.max' => 'The email address may not be greater than :max characters.',
            'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone must be a string.',
            'phone.min' => 'The phone must be at least :min characters.',
            'phone.max' => 'The phone may not be greater than :max characters.',
            'phone.regex' => 'The phone must be a valid phone number.',
            'contact_subject_id.required' => 'The subject field is required.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'message.min' => 'The message must be at least :min characters.',
            'message.max' => 'The message may not be greater than :max characters.',
            'privacy_policy.required' => 'You must accept the privacy policy.',
        ];
    }
}

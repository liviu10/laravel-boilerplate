<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
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

        if ($currentRouteName === 'users.store')
        {
            $rules = [
                'first_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|string|min:3|max:255|unique:users',
            ];
        }

        if ($currentRouteName === 'users.update')
        {
            $rules = [
                'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            ];
        }

        if ($currentRouteName === 'register')
        {
            $rules = [
                'first_name'=> 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'nickname' => 'required|string|min:3|max:100',
                'email' => 'required|string|min:3|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ];
        }

        if ($currentRouteName === 'login')
        {
            $rules = [
                'email' => 'required|string|min:3|max:255',
                'password' => 'required|string|min:8',
            ];
        }

        if ($currentRouteName === 'users.profile')
        {
            $rules = [
                'first_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'sometimes|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
                'nickname' => 'sometimes|string|min:3|max:100',
                'email' => 'sometimes|string|min:3|max:255',
                'phone' => 'sometimes|string|min:7|max:15|regex:/^\+?(?:[0-9][ .-]?){6,14}[0-9]$/',
                'password' => 'sometimes|string|min:8|confirmed',
                'profile_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
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
            'first_name.string' => 'The first name must be a string.',
            'first_name.min' => 'The first name must be at least :min characters.',
            'first_name.max' => 'The first name may not be greater than :max characters.',
            'first_name.regex' => 'The first name must contain only letters and spaces.',
            'last_name.string' => 'The last name must be a string.',
            'last_name.min' => 'The last name must be at least :min characters.',
            'last_name.max' => 'The last name may not be greater than :max characters.',
            'last_name.regex' => 'The last name must contain only letters and spaces.',
            'nickname.string' => 'The nickname must be a string.',
            'nickname.min' => 'The nickname must be at least :min characters.',
            'nickname.max' => 'The nickname may not be greater than :max characters.',
            'email.string' => 'The email must be a string.',
            'email.min' => 'The email must be at least :min characters.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.unique' => 'The email has already been taken.',
            'phone.string' => 'The phone must be a string.',
            'phone.min' => 'The phone must be at least :min characters.',
            'phone.max' => 'The phone may not be greater than :max characters.',
            'phone.regex' => 'The phone format is invalid.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least :min characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'profile_image.image' => 'The profile image must be an image file.',
            'profile_image.mimes' => 'The profile image must be an image with a valid extension.',
        ];
    }
}

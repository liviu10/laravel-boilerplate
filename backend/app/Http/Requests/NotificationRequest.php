<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class NotificationRequest extends FormRequest
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
        $rules = [];

        // Validation rules when creating
        if ($currentRouteName === 'notifications.store')
        {
            $rules = [
                'type' => [
                    'required',
                    'string',
                    Rule::in(['SMS', 'Email'])
                ],
                'condition' => [
                    'required',
                    'string',
                    Rule::in(['Read', 'Create', 'Show', 'Update', 'Delete', 'Restore'])
                ],
                'title' => 'required|string|min:3|max:255',
                'content' => 'required|string|min:50',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'notifications.update')
        {
            $rules = [
                'type' => [
                    'sometimes',
                    'string',
                    Rule::in(['SMS', 'Email'])
                ],
                'condition' => [
                    'sometimes',
                    'string',
                    Rule::in(['Read', 'Create', 'Show', 'Update', 'Delete', 'Restore'])
                ],
                'title' => 'sometimes|string|min:3|max:255',
                'content' => 'sometimes|string|min:50',
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
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'type.in' => 'The selected type is invalid.',
            'condition.required' => 'The condition field is required.',
            'condition.string' => 'The condition must be a string.',
            'condition.in' => 'The selected condition is invalid.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'content.min' => 'The content must be at least :min characters.',
            'content.max' => 'The content may not be greater than :max characters.',
        ];
    }
}

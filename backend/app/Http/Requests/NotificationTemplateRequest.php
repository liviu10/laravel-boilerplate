<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class NotificationTemplateRequest extends FormRequest
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
    static function rules()
    {
        $currentRouteName = Route::current()->getName();
        $rules = [];

        // Validation rules when creating
        if ($currentRouteName === 'templates.store')
        {
            $rules = [
                'notification_type_id' => 'required',
                'notification_condition_id' => 'required',
                'title' => 'required|string|min:3|max:255',
                'content' => 'required|string|min:50',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'templates.update')
        {
            $rules = [
                'notification_type_id' => 'sometimes',
                'notification_condition_id' => 'sometimes',
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
    public function messages(): array
    {
        return [
            'notification_type_id.required' => 'The notification type field is required.',
            'notification_condition_id.required' => 'The notification condition field is required.',
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

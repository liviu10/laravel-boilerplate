<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterCampaignRequest extends FormRequest
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
        return [
            'name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',
            'description' => 'sometimes|string',
            'is_active' => 'required|boolean',
            'valid_from' => 'required|date_format:Y-m-d H:i:s',
            'valid_to' => 'required|date_format:Y-m-d H:i:s',
            'occur_times' => 'required|integer|min:1',
            'occur_week' => 'required|integer|min:1',
            'occur_day' => 'required|integer|min:1',
            'occur_hour' => 'required|date_format: H:i:s',
            'user_id' => 'required|integer',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'name.regex' => 'The name must contain only letters and spaces.',
            'description.string' => 'The description must be a string.',
            'is_active.required' => 'The is active field is required.',
            'is_active.boolean' => 'The is active field must be a boolean value.',
            'valid_from.required' => 'The valid from field is required.',
            'valid_from.date_format' => 'The valid from must be a date in the format Y-m-d H:i:s.',
            'valid_to.required' => 'The valid to field is required.',
            'valid_to.date_format' => 'The valid to must be a date in the format Y-m-d H:i:s.',
            'occur_times.required' => 'The occur times field is required.',
            'occur_times.integer' => 'The occur times must be an integer.',
            'occur_times.min' => 'The occur times must be at least :min.',
            'occur_week.required' => 'The occur week field is required.',
            'occur_week.integer' => 'The occur week must be an integer.',
            'occur_week.min' => 'The occur week must be at least :min.',
            'occur_day.required' => 'The occur day field is required.',
            'occur_day.integer' => 'The occur day must be an integer.',
            'occur_day.min' => 'The occur day must be at least :min.',
            'occur_hour.required' => 'The occur hour field is required.',
            'occur_hour.date_format' => 'The occur hour must be a time in the format H:i:s.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class NewsletterCampaignRequest extends FormRequest
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
        if ($currentRouteName === 'campaigns.store')
        {
            $rules = [
                'name' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:10|max:255|',
                'is_active' => 'required',
                'valid_from' => 'required',
                'valid_to' => 'required',
                'occur_times' => 'required|integer|min:1',
                'occur_week' => 'required|integer|min:1|max:53',
                'occur_day' => 'required|integer|min:1|max:7',
                'occur_hour' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'campaigns.update')
        {
            $rules = [
                'name' => 'sometimes|string|min:3|max:255',
                'description' => 'sometimes|string|min:10|max:255|',
                'is_active' => 'sometimes',
                'valid_from' => 'sometimes',
                'valid_to' => 'sometimes',
                'occur_times' => 'sometimes|integer|min:1',
                'occur_week' => 'sometimes|integer|min:1|max:53',
                'occur_day' => 'sometimes|integer|min:1|max:7',
                'occur_hour' => 'sometimes',
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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'is_active.required' => 'The is active field is required.',
            'valid_from.required' => 'The valid from field is required.',
            'valid_to.required' => 'The valid to field is required.',
            'occur_times.required' => 'The occur times field is required.',
            'occur_times.integer' => 'The occur times must be an integer.',
            'occur_times.min' => 'The occur times must be at least :min.',
            'occur_week.required' => 'The occur week field is required.',
            'occur_week.integer' => 'The occur week must be an integer.',
            'occur_week.min' => 'The occur week must be at least :min.',
            'occur_week.max' => 'The occur week may not be greater than :max.',
            'occur_day.required' => 'The occur day field is required.',
            'occur_day.integer' => 'The occur day must be an integer.',
            'occur_day.min' => 'The occur day must be at least :min.',
            'occur_day.max' => 'The occur day may not be greater than :max.',
            'occur_hour.required' => 'The occur hour field is required.',
        ];
    }
}

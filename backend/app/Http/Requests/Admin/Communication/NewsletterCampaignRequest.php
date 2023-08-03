<?php

namespace App\Http\Requests\Admin\Communication;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'name'        => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:255|',
            'is_active'   => 'required',
            'valid_from'  => 'required',
            'valid_to'    => 'required',
            'occur_times' => 'required',
            'occur_week'  => 'required',
            'occur_day'   => 'required',
            'occur_hour'  => 'required',
        ];

        if ($this->isMethod('PUT')) {
            $rules = array_map(function ($rule) {
                return str_replace('required|', 'sometimes|', $rule);
            }, $rules);
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
            'name.regex' => 'The name may only contain letters and spaces.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'is_active.required' => 'You must activate this campaign.',
            'valid_from.required' => 'You must specify the starting date and time for this campaign.',
            'valid_to.required' => 'You must specify the ending date and time for this campaign.',
            'occur_times.required' => 'You must specify the number of occurrences for this campaign.',
            'occur_week.required' => 'You must specify the number of the week when this campaign will occur.',
            'occur_day.required' => 'You must specify the number of the week day when this campaign will occur.',
            'occur_hour.required' => 'You must specify the starting hour for this campaign.',
        ];
    }
}

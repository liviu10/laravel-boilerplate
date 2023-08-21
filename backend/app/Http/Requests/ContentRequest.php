<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentRequest extends FormRequest
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
            'visibility'    => [
                'required',
                'string',
                Rule::in(['Public', 'Private', 'Draft'])
            ],
            'content_url'   => 'required|string|min:10|max:255',
            'title'         => 'required|string|min:10|max:255',
            'content_type'  => [
                'required',
                'string',
                Rule::in(['Page', 'Article'])
            ],
            'description'   => 'required|string|min:10|max:255',
            'content'       => 'required|string|min:100',
            'allow_comment' => 'required',
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
            'visibility.required' => 'The visibility field is required.',
            'visibility.string' => 'The visibility must be a string.',
            'visibility.in' => 'The selected visibility is invalid.',
            'content_url.required' => 'The content URL field is required.',
            'content_url.string' => 'The content URL must be a string.',
            'content_url.min' => 'The content URL must be at least :min characters.',
            'content_url.max' => 'The content URL may not be greater than :max characters.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'content_type.required' => 'The content type field is required.',
            'content_type.string' => 'The content type must be a string.',
            'content_type.in' => 'The selected content type is invalid.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'content.min' => 'The content must be at least :min characters.',
            'allow_comment.required' => 'The allow comment field is required.',
        ];
    }
}

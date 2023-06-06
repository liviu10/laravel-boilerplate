<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AcceptedDomainRequest extends FormRequest
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
        return [
            'domain' => 'required|max:50|regex:/^[a-z]+$/|unique:accepted_domains',
            'type'   => 'required|max:50',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'domain.required' => 'Field <:attribute> is required!',
            'domain.max'      => 'Field <:attribute> must not exceed :max characters!',
            'domain.regex'    => 'Field <:attribute> must contain only lower letters and no special characters!',
            'domain.unique'   => 'Field <:attribute> must be a unique value!',
            'type.required'   => 'Field <:attribute> is required!',
            'type.max'        => 'Field <:attribute> must not exceed :max characters!',
        ];
    }
}

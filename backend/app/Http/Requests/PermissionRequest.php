<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class PermissionRequest extends FormRequest
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
        if ($currentRouteName === 'permissions.store')
        {
            $rules = [
                'name' => 'required|string',
                'description' => 'required|string|min:255',
                'is_active' => 'required',
                'need_approval' => 'required',
                'report_to_role_id' => 'required',
                'role_id' => 'required',
            ];
        }

        // Validation rules when updating
        if ($currentRouteName === 'permissions.update')
        {
            $rules = [
                'title' => 'sometimes|string|min:3|max:255',
                'content' => 'sometimes|string|min:50',
                'is_active' => 'sometimes',
                'need_approval' => 'sometimes',
                'report_to_role_id' => 'sometimes',
                'role_id' => 'sometimes',
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
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'is_active.required' => 'The is active field is required.',
            'need_approval.required' => 'The need approval field is required.',
            'report_to_role_id.required' => 'The report to role ID field is required.',
            'role_id.required' => 'The role ID field is required.',
        ];
    }
}

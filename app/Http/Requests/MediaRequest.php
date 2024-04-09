<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class MediaRequest extends FormRequest
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

        if ($currentRouteName === 'media.store') {
            $rules = [
                'media_type_id' => 'required|integer',
                'content_id' => 'required|integer',
                'internal_path' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
                'external_path' => 'sometimes|string',
            ];
        }

        if ($currentRouteName === 'media.store') {
            $rules = [
                'media_type_id' => 'sometimes|integer',
                'content_id' => 'sometimes|integer',
                'internal_path' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff',
                'external_path' => 'sometimes|string',
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
            'media_type_id.required' => 'The media type ID field is required.',
            'media_type_id.integer' => 'The media type ID must be an integer.',
            'content_id.required' => 'The content ID field is required.',
            'content_id.integer' => 'The content ID must be an integer.',
            'internal_path.image' => 'The :attribute must be an image file.',
            'internal_path.mimes' => 'The :attribute must be an image with a valid extension.',
            'external_path.string' => 'The external path must be a string.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
        ];
    }
}

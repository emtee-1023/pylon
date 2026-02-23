<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppConfigRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'app_id' => 'required|exists:api_keys,id',
            'primary_color_light' => 'nullable|string|max:7',
            'primary_color_dark' => 'nullable|string|max:7',
            'secondary_color_light' => 'nullable|string|max:7',
            'secondary_color_dark' => 'nullable|string|max:7',
            'background_color_light' => 'nullable|string|max:7',
            'background_color_dark' => 'nullable|string|max:7',
            'surface_color_light' => 'nullable|string|max:7',
            'surface_color_dark' => 'nullable|string|max:7',
            'logo_url' => 'nullable|url',
            'default_theme_mode' => 'nullable|string|in:light,dark,system',
            'api_endpoint' => 'nullable|url',
        ];
    }

    /**
     * Custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'company_id.required' => 'Company ID is required.',
            'company_id.exists' => 'The specified company does not exist.',
            'app_id.required' => 'App ID is required.',
            'app_id.exists' => 'The specified app does not exist.',
            'primary_color_light.string' => 'Primary color must be a string.',
            'primary_color_dark.string' => 'Primary color must be a string.',
            'primary_color_light.max' => 'Primary color cannot exceed 7 characters.',
            'primary_color_dark.max' => 'Primary color cannot exceed 7 characters.',
            'secondary_color_light.string' => 'Secondary color must be a string.',
            'secondary_color_dark.string' => 'Secondary color must be a string.',
            'secondary_color_light.max' => 'Secondary color cannot exceed 7 characters.',
            'secondary_color_dark.max' => 'Secondary color cannot exceed 7 characters.',
            'background_color_light.string' => 'Background color must be a string.',
            'background_color_dark.string' => 'Background color must be a string.',
            'background_color_light.max' => 'Background color cannot exceed 7 characters.',
            'background_color_dark.max' => 'Background color cannot exceed 7 characters.',
            'surface_color_light.string' => 'Surface color must be a string.',
            'surface_color_dark.string' => 'Surface color must be a string.',
            'surface_color_light.max' => 'Surface color cannot exceed 7 characters.',
            'surface_color_dark.max' => 'Surface color cannot exceed 7 characters.',
            'logo_url.url' => 'Logo URL must be a valid URL.',
            'default_theme_mode.string' => 'Default theme mode must be a string.',
            'default_theme_mode.in' => 'Default theme mode must be one of: light, dark, system.',
            'api_endpoint.url' => 'API endpoint must be a valid URL.',
        ];
    }
}

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
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'background_color' => 'nullable|string',
            'surface_color' => 'nullable|string',
            'logo_url' => 'nullable|url',
            'theme_mode' => 'nullable|string|in:light,dark,system',
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
            'primary_color.string' => 'Primary color must be a string.',
            'secondary_color.string' => 'Secondary color must be a string.',
            'background_color.string' => 'Background color must be a string.',
            'surface_color.string' => 'Surface color must be a string.',
            'logo_url.url' => 'Logo URL must be a valid URL.',
            'theme_mode.string' => 'Theme mode must be a string.',
            'theme_mode.in' => 'Theme mode must be one of: light, dark, system.',
            'api_endpoint.url' => 'API endpoint must be a valid URL.',
        ];
    }
}

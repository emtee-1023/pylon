<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'app_id' => 'nullable|exists:api_keys,id',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'background_color' => 'nullable|string|max:7',
            'surface_color' => 'nullable|string|max:7',
            'theme_mode' => 'nullable|in:light,dark,system',
            'api_endpoint' => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required.',
            'company_name.string' => 'Company name must be a string.',
            'company_name.max' => 'Company name cannot exceed 255 characters.',
            'app_id.exists' => 'The selected App ID is invalid.',
            'primary_color.regex' => 'Primary color must be a valid hex code.',
            'secondary_color.regex' => 'Secondary color must be a valid hex code.',
            'background_color.regex' => 'Background color must be a valid hex code.',
            'surface_color.regex' => 'Surface color must be a valid hex code.',
            'theme_mode.in' => 'Theme mode must be one of: light, dark, system.',
            'api_endpoint.url' => 'API endpoint must be a valid URL.',
        ];
    }
}

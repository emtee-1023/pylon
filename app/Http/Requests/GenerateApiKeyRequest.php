<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateApiKeyRequest extends FormRequest
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
            'app_name' => 'required|string|max:255',
            'scopes' => 'array',
            'scopes.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'app_name.required' => 'The application name is required.',
            'app_name.string' => 'The application name must be a string.',
            'app_name.max' => 'The application name may not be greater than 255 characters.',
            'scopes.array' => 'The scopes must be an array.',
            'scopes.*.string' => 'Each scope must be a string.',
        ];
    }
}

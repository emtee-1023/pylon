<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAppConfigsRequest extends FormRequest
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
            'company_id' => 'required|integer|exists:companies,id',
            'app_id' => 'required|integer|exists:api_keys,id',
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => 'The company_id field is required.',
            'company_id.integer' => 'The company_id must be an integer.',
            'company_id.exists' => 'The specified company_id does not exist.',
            'app_id.required' => 'The app_id field is required.',
            'app_id.integer' => 'The app_id must be an integer.',
            'app_id.exists' => 'The specified app_id does not exist.',
        ];
    }
}

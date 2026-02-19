<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiKeyService;
use App\Http\Requests\GenerateApiKeyRequest;

class ConfigureAppController extends Controller
{
    public function generateApiKey(GenerateApiKeyRequest $request, ApiKeyService $apiKeyService)
    {
        $request->validated();

        $result = $apiKeyService->generate(
            $request->input('app_name'),
            $request->input('scopes', [])
        );

        return response()->json([
            'message' => 'API key generated successfully. Note that for security reasons, the API key will only be shown once. Please store it securely.',
            'data' => [
                'api_key' => $result['api_key'], // show once
                'record' => $result['record'],
            ],
        ], 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Company;
use App\Models\CompanyApp;
use Illuminate\Http\Request;

/**
 * @tags Configurations
 */
class ConfigController extends Controller
{
    /**
     * Get App Configuration
     *
     * This endpoint returns company-specific configuration based on the provided `company_id` and the API key in the request header.
     */
    public function getConfig(Request $request)
    {
        $companyId = $request->input('company_id');
        $apiKey = $request->header('X-API-KEY');

        $hashedKey = hash('sha256', $apiKey);

        $apiKeyRecord = ApiKey::where('key_hash', $hashedKey)
            ->where('active', true)
            ->first();

        if (! $apiKeyRecord) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $apiKeyRecord->update(['last_used_at' => now()]);
        $appId = $apiKeyRecord->id;
        $app = CompanyApp::where('app_id', $appId)->first();


        if (! $companyId) {
            return response()->json(['message' => 'company_id is required'], 400);
        }

        $company = Company::where('company_id', $companyId)->first();

        if (! $company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json([
            'company_id' => $company->company_id,
            'branding' => [
                'company_name' => $company->name,
                'logo_url' => $app->branding['logo_url'] ?? null,
                'primary_color' => $app->branding['primary_color'] ?? null,
                'secondary_color' => $app->branding['secondary_color'] ?? null,
                'surface_color' => $app->branding['surface_color'] ?? null,
                'background_color' => $app->branding['background_color'] ?? null,
                'theme_mode' => $app->branding['theme_mode'] ?? null,
            ],
            'api' => [
                'base_url' => $app->api_config['endpoint'] ?? null,
            ],
        ]);
    }
}

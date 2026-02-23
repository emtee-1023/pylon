<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\GenerateApiKeyRequest;
use App\Http\Requests\CreateAppConfigRequest;
use App\Http\Requests\DeleteAppConfigsRequest;
use App\Models\ApiKey;
use App\Models\Company;
use App\Models\CompanyApp;
use App\Services\ApiKeyService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @tags App Deployment
 */
class DeploymentController extends Controller
{
    /**
     * Generate API key
     *
     * This endpoint allows administrators to generate a new API key for a specific application.
     *
     * For security reasons, the generated API key will only be shown once in the response. Please make sure to store it securely, as it cannot be retrieved again after this response.
     */
    public function generateApiKey(GenerateApiKeyRequest $request, ApiKeyService $apiKeyService)
    {
        try {
            $request->validated();

            $result = $apiKeyService->generate(
                $request->input('app_name'),
                $request->input('scopes', [])
            );

            return response()->json([
                'message' => 'API key generated successfully. Note that for security reasons, the API key will only be shown once. Please store it securely.',
                'data' => [
                    'api_key' => $result['api_key'],
                    'record' => $result['record'],
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while generating API key.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create new Company
     *
     * This endpoint allows administrators to create a new company profile. The company can be linked to specific applications via the app_id, and can have custom branding options such as colors and theme mode.
     */
    public function createCompany(CreateCompanyRequest $request)
    {
        try {
            $request->validated();

            $company = Company::create([
                'name' => $request->input('company_name'),
                'company_id' => str_replace(' ', '', strtolower($request->input('company_name'))),
            ]);

            $companyApp = CompanyApp::create([
                'company_id' => $company->id,
                'app_id' => $request->input('app_id'),
                'branding' => [
                    'primary_color_light' => $request->input('primary_color_light'),
                    'primary_color_dark' => $request->input('primary_color_dark'),
                    'secondary_color_light' => $request->input('secondary_color_light'),
                    'secondary_color_dark' => $request->input('secondary_color_dark'),
                    'background_color_light' => $request->input('background_color_light'),
                    'background_color_dark' => $request->input('background_color_dark'),
                    'surface_color_light' => $request->input('surface_color_light'),
                    'surface_color_dark' => $request->input('surface_color_dark'),
                    'logo_url' => $request->input('logo_url'),
                    'default_theme_mode' => $request->input('default_theme_mode'),
                ],
                'api_config' => [
                    'endpoint' => $request->input('api_endpoint'),
                ],
            ]);

            return response()->json([
                'message' => 'Company created successfully.',
                'data' => [
                    'company' => $company,
                    'linked_app' => [
                        'app_id' => $companyApp->app_id,
                        'app_name' => $companyApp->app->app_name,
                        'api_key_hash' => $companyApp->app->key_hash,
                        'branding' => $companyApp->branding,
                        'api_config' => $companyApp->api_config,
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating company.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Deployed Apps
     *
     * This endpoint retrieves a list of all deployed applications.
     */
    public function getDeployedApps()
    {
        try {
            $apps = ApiKey::paginate(10);

            return response()->json([
                'message' => 'Deployed applications retrieved successfully.',
                'data' => $apps->map(fn($app) => [
                    'app_id' => $app->id,
                    'app_name' => $app->app_name,
                    'platform' => 'Android & iOS',
                    'version' => '1.0.0',
                    'status' => $app->active ? 'Active' : 'Inactive',
                    'deployed_at' => Carbon::parse($app->created_at)->format('jS F Y'),
                ]),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving deployed apps.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get API Keys
     *
     * This endpoint retrieves a list of all API keys along with their associated application names
     */
    public function getApiKeys()
    {
        try {
            $apiKeys = ApiKey::paginate(10);

            return response()->json([
                'message' => 'API keys retrieved successfully.',
                'data' => $apiKeys->map(fn($apiKey) => [
                    'api_key_id' => $apiKey->id,
                    'app_name' => $apiKey->app_name,
                    'generated_at' => Carbon::parse($apiKey->created_at)->format('jS F Y \a\t h:i A'),
                    'status' => $apiKey->active ? 'Active' : 'Inactive',
                ]),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving API keys.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Companies
     *
     * This endpoint retrieves a list of all companies along with their linked applications.
     */
    public function getCompanies()
    {
        try {
            $companies = Company::paginate(10);

            return response()->json([
                'message' => 'Companies retrieved successfully.',
                'data' => $companies->map(fn($company) => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'company_id' => $company->company_id,
                    'linked_apps' => $company->apps()->pluck('app_name'),
                ]),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving companies.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete API key
     *
     * This endpoint allows administrators to delete an existing API key by its ID. Deleting an API key will revoke access for any applications using that key, so please use this action with caution.
     */
    public function deleteApiKey(Request $request, $id)
    {
        try {
            $apiKey = ApiKey::findOrFail($id);
            $apiKey->delete();

            return response()->json([
                'message' => 'API key deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting API key.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create App Config
     * 
     * This endpoint is used to create an app configuration for a specific company
     */

    public function createAppConfig(CreateAppConfigRequest $request)
    {
        try {
            $request->validated();

            $companyApp = CompanyApp::create([
                'company_id' => $request->input('company_id'),
                'app_id' => $request->input('app_id'),
                'branding' => [
                    'primary_color_light' => $request->input('primary_color_light'),
                    'primary_color_dark' => $request->input('primary_color_dark'),
                    'secondary_color_light' => $request->input('secondary_color_light'),
                    'secondary_color_dark' => $request->input('secondary_color_dark'),
                    'background_color_light' => $request->input('background_color_light'),
                    'background_color_dark' => $request->input('background_color_dark'),
                    'surface_color_light' => $request->input('surface_color_light'),
                    'surface_color_dark' => $request->input('surface_color_dark'),
                    'logo_url' => $request->input('logo_url'),
                    'default_theme_mode' => $request->input('default_theme_mode'),
                ],
                'api_config' => [
                    'endpoint' => $request->input('api_endpoint'),
                ],
            ]);

            return response()->json([
                'message' => 'App configuration created successfully.',
                'data' => [
                    'company_name' => $companyApp->company->name,
                    'company_id' => $companyApp->company->company_id,
                    'app_id' => $companyApp->app_id,
                    'app_name' => $companyApp->app->app_name,
                    'branding' => $companyApp->branding,
                    'api_config' => $companyApp->api_config,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating app configuration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get App Configs
     * 
     * This endpoint retrieves the company specific configurations for all applications, including branding and API configuration details.
     */
    public function getAppConfigs()
    {
        try {
            $companyApps = CompanyApp::with('app')->paginate(10);

            return response()->json([
                'message' => 'App configurations retrieved successfully.',
                'data' => $companyApps->map(fn($companyApp) => [
                    'company_name' => $companyApp->company->name,
                    'company_id' => $companyApp->company->company_id,
                    'app_id' => $companyApp->app_id,
                    'app_name' => $companyApp->app->app_name,
                    'platform' => 'Android & iOS',
                    'version' => '1.0.0',
                    'branding' => $companyApp->branding,
                    'api_config' => $companyApp->api_config,
                ]),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving app configurations.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAppConfig(Request $request, $company_id, $app_id)
    {
        try {
            $companyApp = CompanyApp::where('company_id', $company_id)
                ->where('app_id', $app_id)
                ->with('app')
                ->firstOrFail();

            return response()->json([
                'message' => 'App configuration retrieved successfully.',
                'data' => [
                    'company_name' => $companyApp->company->name,
                    'company_id' => $companyApp->company_id,
                    'app_id' => $companyApp->app_id,
                    'app_name' => $companyApp->app->app_name,
                    'platform' => 'Android & iOS',
                    'version' => '1.0.0',
                    'branding' => $companyApp->branding,
                    'api_config' => $companyApp->api_config,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving app configuration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Patch App Config
     * 
     * This endpoint is used to update the app configuration for a specific company and app combination. It allows updating both branding and API configuration details.
     */

    public function patchAppConfig(CreateAppConfigRequest $request)
    {
        try {
            $request->validated();

            $companyApp = CompanyApp::where('company_id', $request->input('company_id'))
                ->where('app_id', $request->input('app_id'))
                ->firstOrFail();

            $companyApp->update([
                'branding' => [
                    'primary_color_light' => $request->input('primary_color_light'),
                    'primary_color_dark' => $request->input('primary_color_dark'),
                    'secondary_color_light' => $request->input('secondary_color_light'),
                    'secondary_color_dark' => $request->input('secondary_color_dark'),
                    'background_color_light' => $request->input('background_color_light'),
                    'background_color_dark' => $request->input('background_color_dark'),
                    'surface_color_light' => $request->input('surface_color_light'),
                    'surface_color_dark' => $request->input('surface_color_dark'),
                    'logo_url' => $request->input('logo_url'),
                    'default_theme_mode' => $request->input('default_theme_mode'),
                ],
                'api_config' => [
                    'endpoint' => $request->input('api_endpoint'),
                ],
            ]);

            return response()->json([
                'message' => 'App configuration updated successfully.',
                'data' => [
                    'company_name' => $companyApp->company->name,
                    'company_id' => $companyApp->company->company_id,
                    'app_id' => $companyApp->app_id,
                    'app_name' => $companyApp->app->app_name,
                    'branding' => $companyApp->branding,
                    'api_config' => $companyApp->api_config,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating app configuration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete App Config
     * 
     * This endpoint is used to delete the app configuration for a specific company and app combination. Deleting an app configuration will remove all custom branding and API configuration details for that company and app, reverting to default settings if applicable.
     */

    public function deleteAppConfig(DeleteAppConfigsRequest $request)
    {
        try {
            $request->validated();

            $companyApp = CompanyApp::where('company_id', $request->input('company_id'))
                ->where('app_id', $request->input('app_id'))
                ->firstOrFail();

            $companyApp->delete();

            return response()->json([
                'message' => 'App configuration deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting app configuration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\GenerateApiKeyRequest;
use App\Models\ApiKey;
use App\Models\Company;
use App\Services\ApiKeyService;
use Illuminate\Http\Request;

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
                'primary_color' => $request->input('primary_color'),
                'secondary_color' => $request->input('secondary_color'),
                'background_color' => $request->input('background_color'),
                'surface_color' => $request->input('surface_color'),
                'theme_mode' => $request->input('theme_mode'),
                'api_endpoint' => $request->input('api_endpoint'),
            ]);

            return response()->json([
                'message' => 'Company created successfully.',
                'data' => $company,
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
                    'deployed_at' => $app->created_at,
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
                    'generated_at' => $apiKey->created_at,
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
                    'linked_apps' => $company->apiKeys()->pluck('app_name'),
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
}

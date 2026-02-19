<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        if (! $companyId) {
            return response()->json(['message' => 'company_id is required'], 400);
        }

        $company = Company::find($companyId);

        if (! $company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json([
            'company_id' => $company->id,
            'branding' => $company->branding,
            'api' => $company->api_config,
        ]);
    }
}

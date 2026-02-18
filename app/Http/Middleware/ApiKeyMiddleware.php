<?php

//Protected route Route::middleware('apikkey')

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $incomingKey = $request->header('X-API-KEY');

        if (!$incomingKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $hashed = hash('sha256', $incomingKey);

        $apiKey = ApiKey::where('key_hash', $hashed)
            ->where('active', true)
            ->first();

        if (!$apiKey) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        // Optional: Update last used
        $apiKey->update([
            'last_used_at' => now()
        ]);

        // Attach tenant context
        $request->attributes->set('company_id', $apiKey->company_id);
        $request->attributes->set('api_scopes', $apiKey->scopes ?? []);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $incomingKey = $request->header('X-API-KEY');

        if (! $incomingKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $hashed = hash('sha256', $incomingKey);

        $apiKey = ApiKey::where('key_hash', $hashed)
            ->where('active', true)
            ->first();

        if (! $apiKey) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $apiKey->update(['last_used_at' => now()]);

        return $next($request);
    }
}

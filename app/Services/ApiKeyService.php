<?php

// app/Services/ApiKeyService.php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function generate(string $appName, array $scopes = [])
    {
        $rawKey = "pyl_{$appName}_" . Str::random(54);

        $apiKey = ApiKey::create([
            'app_name' => $appName,
            'key_hash' => hash('sha256', $rawKey),
            'scopes' => $scopes,
            'active' => true,
        ]);

        return [
            'api_key' => $rawKey, // show once
            'record' => $apiKey,
        ];
    }
}

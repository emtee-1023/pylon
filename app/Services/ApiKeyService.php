<?php
// app/Services/ApiKeyService.php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function generate(string $name, string $companyId, array $scopes = [])
    {
        $rawKey = Str::random(64);

        $apiKey = ApiKey::create([
            'name' => $name,
            'key_hash' => hash('sha256', $rawKey),
            'company_id' => $companyId,
            'scopes' => $scopes,
            'active' => true,
        ]);

        return [
            'api_key' => $rawKey, // show once
            'record' => $apiKey,
        ];
    }
}

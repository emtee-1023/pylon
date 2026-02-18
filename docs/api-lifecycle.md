# End-to-End Lifecycle of an API Key in Pylon

The mobile app being deployed to the App Store contains an API key from pylon in its environment. Customers only provide their `company_id` — the app uses the API key silently in the background.

```
┌─────────────────────────────────────────────────────────────┐
│                    Your Published App                       │
│  ┌─────────────────────────────────────────────────────┐    │
│  │  PYLON_API_KEY=pyl_live_83js9dk29sks92ks0sks...    │    │
│  └─────────────────────────────────────────────────────┘    │
│                           │                                 │
│                           ▼                                 │
│  User enters: company_id = "acme_corp"                      │
│                           │                                 │
│                           ▼                                 │
│  App calls Pylon: GET /api/v1/config/acme_corp             │
│  Header: X-API-KEY: pyl_live_83js9dk29sks92ks0sks...       │
└─────────────────────────────────────────────────────────────┘
```

## Phase 1 — Provisioning (Internal)

This happens when:

- A new tenant is onboarded

### Step 1: Generate the Key

You (or an admin panel) run:

```php
$service->generate(
    'Kinetic Technology Limited', (company name)
    'a5ab3645-b95c-ec11-8f6f-0666489d8ee3', (company id)
    '{
    "company_id": "a5ab3645-b95c-ec11-8f6f-0666489d8ee3",
    "branding": {
        "name": "Kinetic Technology Limited",
        "primary_color": "#FFA500",
        "logo_url": "https://kinetics.co.ke/wp-content/uploads/2021/03/KTL-Logo-1.png"
    },
    "api": {
        "base_url": "https://api.platform.example.com"
    }
}' (configurations )
);
```

System does:

1. Generates random 64-char string
2. Hashes it
3. Stores only the hash
4. Returns raw key ONCE

Example raw key:

```
pyl_live_83js9dk29sks92ks0sks...
```

## Phase 2 — Embedded in Your App

The API key is compiled into your mobile app .env. End customers never see it.

```env
# Your app's environment file
PYLON_API_KEY=pyl_live_83js9dk29sks92ks0sks...
```

When a customer launches your app and enters their company ID:

```http
POST /api/v1/config
Content-Type: application/json
X-API-KEY: pyl_live_83js9dk29sks92ks0sks...

{
  "company_id": "a5ab3645-b95c-ec11-8f6f-0666489d8ee3"
}
```

## What Happens on Every Request

1. App sends request with embedded API key + customer-provided company_id
2. Middleware reads `X-API-KEY`
3. Hashes incoming key
4. Looks up matching `key_hash`
5. Validates:
    - Exists
    - Active
6. Attaches:
    ```php
    $request->attributes->set('company_id', $apiKey->company_id);
    $request->attributes->set('scopes', $apiKey->scopes);
    ```
7. Controller uses `company_id` to return tenant-specific config

That's it. Stateless. Clean. Fast.

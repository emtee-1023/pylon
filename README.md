# Pylon

> Centralized multi-tenant deployment and configuration orchestration platform for mobile applications.

Pylon is a multi-tenant orchestration service that manages deployment and configuration of mobile applications serving multiple clients from a shared core system.

It enables applications to dynamically adapt per company by retrieving configuration data using a company identifier — while maintaining a single underlying infrastructure and shared feature set.

---

## Overview

Pylon supports a **Multi-Tenant Deployment** model:

> Multiple clients share the same underlying infrastructure and core features. This is generally more economical and faster to deploy since only one app is deployed on app stores but offers limited modification options for individual users.

Instead of maintaining separate deployments per client, applications retrieve company-specific configuration at runtime from Pylon using an API key that identifies the app.

This enables:

- Shared infrastructure across all tenants
- Company-level configuration control
- Reduced operational overhead
- Faster onboarding of new clients
- Controlled customization within shared constraints

---

## Core Responsibilities

- App identification via API keys
- Company-aware configuration delivery
- Centralized deployment coordination
- Environment segmentation
- Version-aware configuration control
- Company isolation

---

## Architecture

```
┌─────────────────────┐
│  Client Application │
│  (e.g., ESS App)    │
└──────────┬──────────┘
           │
           │ Contains API key in .env: pyl_ESS_xxx
           │
           ▼
┌─────────────────────┐
│     Pylon API      │
│  (validates key)   │
└──────────┬──────────┘
           │
           │ Receives company_id from user input
           │
           ▼
┌─────────────────────┐
│ Configuration Store│
│   (companies)      │
└─────────────────────┘
```

Each application contains an API key that identifies the **app** (not the company). Users provide their `company_id` when using the app, and Pylon returns the configuration for that company.

---

## Key Concepts

### App

A deployed application (e.g., ESS, Membership Portal) that embeds a Pylon API key. The API key identifies the app, not the company using it.

### Company

A client organization that uses an app. Each company has its own configuration (branding, API settings) stored in Pylon.

### Configuration Profile

A structured configuration object defining how the application behaves for a specific company, including:

- Branding parameters
- API endpoints

---

## Example API Usage

### Fetch Configuration

```bash
POST /api/config
Content-Type: application/json
X-API-KEY: pyl_ESS_83js9dk29sks92ks0sks...

{
    "company_id": "kinetictechnologylimited" #the company name in lowercase without any spaces
}
```

### Example Response

```json
{
    "company_id": "kinetictechnologylimite",
    "branding": {
        "company_name": "Kinetic Technology Limited",
        "logo_url": "https://kinetics.co.ke/wp-content/uploads/2021/03/KTL-Logo-1.png",
        "primary_color": "#07ca89",
        "secondary_color": "#c21414",
        "surface_color": "#F5F5F5",
        "background_color": "#FFFFFF",
        "theme_mode": "dark"
    },
    "api": {
        "base_url": "https://api.platform.example.com"
    }
}
```

## License

MIT License - see the [LICENSE](LICENSE) file for details.

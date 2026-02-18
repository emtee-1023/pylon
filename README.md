# Pylon

> Centralized multi-tenant deployment and configuration orchestration platform for mobile applications.

Pylon is a multi-tenant orchestration service that manages deployment and configuration of applications serving multiple clients from a shared core system.

It enables applications to dynamically adapt per company by retrieving configuration data using a company identifier — while maintaining a single underlying infrastructure and shared feature set.

---

## Overview

Pylon supports a **Multi-Tenant Deployment** model:

> Multiple clients share the same underlying infrastructure and core features. This is generally more economical and faster to deploy since only one app is deployed on app stores but offers limited modification options for individual users.

Instead of maintaining separate deployments per client, applications retrieve their company-specific configuration at runtime from Pylon.

This enables:

- Shared infrastructure across all tenants
- Company-level configuration control
- Centralized feature management
- Reduced operational overhead
- Faster onboarding of new clients
- Controlled customization within shared constraints

---

## Core Responsibilities

- Tenant-aware configuration delivery
- Centralized deployment coordination
- Feature flag management
- Environment segmentation
- Version-aware configuration control
- Logical tenant isolation

---

## Architecture

```
┌─────────────────────┐
│  Client Application │
└──────────┬──────────┘
           │
           │ Company ID + Auth Token
           ▼
┌─────────────────────┐
│     Pylon API      │
└──────────┬──────────┘
           │
           │ Fetch tenant configuration
           ▼
┌─────────────────────┐
│ Configuration Store│
└─────────────────────┘
```

Each application initializes by calling Pylon with a `company_id`.  
Pylon responds with a configuration payload tailored to that tenant while maintaining shared system integrity.

---

## Key Concepts

### Tenant

A client organization operating within the shared platform.

### Configuration Profile

A structured configuration object defining how the application behaves for a specific tenant, including:

- Branding parameters
- API endpoints

---

## Example API Usage

### Fetch Configuration

```bash
GET /api/v1/config/{company_id}
Authorization: Bearer <token>
```

### Example Response

```json
{
    "company_id": "a5ab3645-b95c-ec11-8f6f-0666489d8ee3",
    "branding": {
        "name": "Kinetic Technology Limited",
        "primary_color": "#FFA500",
        "logo_url": "https://kinetics.co.ke/wp-content/uploads/2021/03/KTL-Logo-1.png"
    },
    "api": {
        "base_url": "https://api.platform.example.com"
    }
}
```

## License

MIT License - see the [LICENSE](LICENSE) file for details.

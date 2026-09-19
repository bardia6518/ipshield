# IPShield

IP Reputation & Threat Intelligence Platform.

## Phase 2 status
Infrastructure & Backend Foundation is implemented through Roadmap Step 2.20.
The final Phase 2 acceptance gate must pass before the phase is frozen.

## Repository layout
- `backend/` — Laravel REST API
- `frontend/` — reserved boundary for the decoupled React frontend
- `docs/` — architecture, policies, ADRs and runbooks
- `infra/` — infrastructure and Linux service templates
- `scripts/` — local/runtime verification and operational scripts

## Primary stack
- Laravel 13 / PHP 8.3+
- PostgreSQL
- Redis-compatible cache/queue
- Laravel Sanctum
- React + TypeScript frontend boundary

API base path: `/api/v1`

## Local verification
From the repository root on Windows:

```powershell
.\scripts\postgres-local-start.ps1
.\scripts\redis-local-start.ps1
.\scripts\phase2-verify.ps1
```

Laravel tests use the isolated PostgreSQL database `ipshield_test`.
Real environment files and credentials are intentionally excluded from Git.

## Linux/staging
See:
- `docs/VPS_READINESS.md`
- `scripts/staging-readiness.sh`
- `infra/nginx/`
- `infra/systemd/`

## Documentation
Start with `docs/README.md`.

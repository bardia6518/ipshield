# IPShield

IP Reputation & Threat Intelligence Platform.

## Repository layout
- `backend/` — Laravel REST API
- `frontend/` — React frontend boundary
- `docs/` — architecture and engineering rules
- `infra/` — infrastructure definitions
- `scripts/` — verification and operational scripts

## Phase 2 scope
Phase 2 establishes the backend and infrastructure foundation only.
It does not implement the final reputation engine, real threat-feed processing,
final admin UI, subscriptions, or machine learning.

Primary stack:
- Laravel / PHP
- PostgreSQL
- Redis
- React + TypeScript (separate frontend)

API base path: `/api/v1`

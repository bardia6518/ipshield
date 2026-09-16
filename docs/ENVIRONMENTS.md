# Environment Architecture

IPShield uses three isolated environments: Local, Staging, Production.
No environment may reuse another environment's database, Redis data, APP_KEY, or external-service credentials.

## Local Development
- `APP_ENV=local`, debug allowed.
- Local PostgreSQL database: `ipshield_local`.
- Local Redis only; synthetic/non-production data only.
- Template: `backend/.env.local.example`.

## Staging
- `APP_ENV=staging`, `APP_DEBUG=false`.
- Dedicated PostgreSQL database/user: `ipshield_staging`.
- Dedicated Redis credentials/instance or isolated logical database.
- Non-production data only.
- Template: `backend/.env.staging.example`.

## Production
- `APP_ENV=production`, `APP_DEBUG=false`.
- Dedicated PostgreSQL database/user: `ipshield_production`.
- Dedicated Redis credentials/instance.
- HTTPS only; production secrets supplied outside Git.
- Template: `backend/.env.production.example`.

## Secret Rules
Secrets include `APP_KEY`, DB and Redis passwords, mail credentials, API secrets,
feed credentials, signing keys, private certificates, and object-storage credentials.
Real secrets are never committed to Git and must be independently rotated per environment.

## Promotion Rule
Code is promoted from Local to Staging and then Production; data and secrets are never promoted between environments.

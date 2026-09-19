# Testing Foundation

## Test database
Automated tests use PostgreSQL only.
Local test database: `ipshield_test`.
It is separate from the development database `ipshield`.

Real test credentials live in ignored `backend/.env.testing`.
Tracked template: `backend/.env.testing.example`.

## Required layers
- Unit tests
- Feature tests
- API contract tests
- Integration tests
- Security-focused tests

## Rules
- tests never use production credentials
- important features are not Done without tests
- factories and fixtures use synthetic data only
- test configuration must fail if it silently falls back to SQLite
- CI must use an isolated PostgreSQL database

## Runtime services
Unit/feature tests default to:
- PostgreSQL for database behavior
- array cache where distributed behavior is not under test
- sync queue where asynchronous delivery is not under test

Redis/queue/scheduler integration is validated separately by Phase 2 runtime probes.

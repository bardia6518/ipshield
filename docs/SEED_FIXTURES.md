# Seed & Fixture Foundation

Phase 2 provides deterministic, synthetic data for local development and automated tests.

## Seeder
`Phase2FixtureSeeder` creates one synthetic user:
- reserved `.test` email domain
- non-production display name
- deterministic identity
- idempotent `updateOrCreate`

## Safety
`DatabaseSeeder` only invokes Phase 2 fixtures in `local` or `testing` environments.
Production seeding is intentionally a no-op unless a future migration/runbook explicitly defines approved production data.

Fixtures must never contain copied customer, credential, threat-feed or production data.

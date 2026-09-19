# Phase 2 Final Acceptance

Phase 2 may be frozen only after every gate below passes on the current `develop` revision.

## Required runtime gates
- Laravel boots cleanly.
- PostgreSQL is the only application/test database engine.
- Redis responds successfully.
- PostgreSQL migrations are current.
- A Redis-backed queue job is dispatched and consumed.
- Failed jobs are persisted and observable.
- Scheduler registration and execution are verified.
- REST API v1 health contract is reachable.
- Logging channels are separated.
- API error responses do not leak internal details.
- Full automated test suite passes.

## Required repository gates
- Real environment files are not tracked.
- Secret scan passes.
- Composer manifest is valid.
- Composer security audit passes.
- No abandoned direct dependency is approved.
- Linux/VPS readiness artifacts exist.
- Documentation matches the current implementation.
- Git working tree is clean after the final acceptance commit.

## Phase boundary
No Phase 3 business logic is required for this gate.
Risk scoring, threat-feed collection, reporting workflows and product UI remain outside Phase 2.

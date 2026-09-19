# IPShield Documentation

## Start here
- [Project Architecture](ARCHITECTURE.md)
- [Phase 2 Status](PHASE2_STATUS.md)
- [Environment Architecture](ENVIRONMENTS.md)
- [Development Conventions](DEV_CONVENTIONS.md)
- [Git Workflow](GIT_WORKFLOW.md)

## Data and infrastructure
- [PostgreSQL Foundation](POSTGRESQL_FOUNDATION.md)
- [Database Governance](DATABASE_GOVERNANCE.md)
- [Redis Foundation](REDIS_FOUNDATION.md)
- [Queue Foundation](QUEUE_FOUNDATION.md)
- [Scheduler Foundation](SCHEDULER_FOUNDATION.md)
- [Storage Architecture](STORAGE.md)
- [VPS / Staging Readiness](VPS_READINESS.md)

## API and backend standards
- [REST API Standard](API_STANDARDS.md)
- [Validation Foundation](VALIDATION.md)
- [Security Baseline](SECURITY_BASELINE.md)
- [Logging & Error Handling](LOGGING_AND_ERRORS.md)
- [Observability](OBSERVABILITY.md)
- [Testing Foundation](TESTING.md)
- [Seed & Fixtures](SEED_FIXTURES.md)
- [Dependency Governance](DEPENDENCIES.md)

## Architecture Decision Records
- [ADR-0001 PostgreSQL](ADR/0001-postgresql.md)
- [ADR-0002 Redis](ADR/0002-redis.md)
- [ADR-0003 REST API](ADR/0003-rest-api.md)
- [ADR-0004 Backend Architecture](ADR/0004-backend-architecture.md)

## Operational scripts
Windows local/runtime:
- `scripts/postgres-local-start.ps1`
- `scripts/redis-local-start.ps1`
- `scripts/queue-worker-local.ps1`
- `scripts/scheduler-local.ps1`
- `scripts/dependency-audit.ps1`
- `scripts/phase2-verify.ps1`

Linux/staging:
- `scripts/staging-readiness.sh`

## Documentation rules
Documentation must describe the repository as it exists, not a planned future state.
Architecture-changing decisions require an ADR.
Runtime commands must be reproducible and must not embed secrets.
Phase 3 business behavior must not be presented as already implemented in Phase 2.

# Queue & Worker Foundation

Queue transport: Redis.
Failed-job persistence: PostgreSQL `failed_jobs` using database UUIDs.

## Future workloads
- threat feed processing
- IP enrichment
- risk recalculation
- file import
- evidence processing
- notifications
- external API synchronization

## Worker policy
Default local queue: `ipshield:queue:default`.
Workers use explicit timeout, retry and queue selection.
Production workers must run under a process supervisor; the Windows script is development-only.

## Retry policy
Foundation defaults:
- max attempts: 3
- timeout: 30 seconds
- backoff: 1s, 2s, 5s for the probe job
- Redis `retry_after`: 90 seconds
- Redis `block_for`: 5 seconds
- dispatch after database commit: enabled

## Idempotency
Jobs that may be retried must be safe to run more than once.
The Phase 2 probe uses both a unique dispatch key and a processed marker.
Future jobs must use domain-specific idempotency keys rather than relying only on queue delivery semantics.

## Failure handling
Failures must be observable through Laravel failed-job tooling and PostgreSQL.
A failed job must retain enough context to identify the job class, payload and failure time.
Retrying a failed job must be deliberate; repeated failure must remain visible.

## Safety rules
Do not perform heavy feed processing in HTTP request handlers.
Do not place authoritative business state only in Redis.
Do not make database writes dependent on a non-idempotent external side effect.
Queue dispatch after DB commit is the default to avoid workers seeing uncommitted state.

## Phase 2 validation
The foundation must prove:
1. a Redis-backed job can be dispatched and processed;
2. repeating the same probe is idempotent;
3. a deliberately failing probe appears in failed jobs;
4. worker configuration and base tests pass.
## Local worker script
Run `scripts/queue-worker-local.ps1` for the development worker.
Use `-Once` only for QA/smoke tests; normal mode stays alive for delayed retries.

# Redis Foundation

Redis is infrastructure, not the system of record. PostgreSQL remains authoritative.

## Responsibilities
- cache
- queue transport
- rate-limit counters
- distributed / short-lived locks
- other explicitly short-lived state

## Client
Laravel uses `predis/predis` for the current development foundation.
Local Windows development uses Memurai Developer as a Redis-compatible runtime.
Staging and production remain targeted at native Redis on Linux.

## Logical separation
- default Redis DB: `0`
- cache Redis DB: `1`

Namespaces:
- cache: `ipshield:cache:`
- queue: `ipshield:queue:`
- rate limit: `ipshield:rate-limit:`
- lock: `ipshield:lock:`
## TTL and invalidation
Generic cache entries default to a bounded TTL; current foundation default is 300 seconds.
Locks always require an explicit short TTL.
Rate-limit keys expire with their limiter window.
Cache entries must be invalidated when authoritative PostgreSQL state changes.
Permanent cache entries require an explicit design review.

## Failure behavior
A Redis outage must never corrupt or replace PostgreSQL state.
Authoritative records must never exist only in Redis.
Dependency failures must be surfaced and logged rather than silently ignored.
Safety-sensitive locks and rate limits must fail safely when Redis is unavailable.
Queue failure/retry/idempotency rules are defined in Phase 2.6.

## Local runtime
Local Memurai binds only to `127.0.0.1:6379`, requires authentication,
and uses AOF persistence with `appendfsync everysec`.
The local secret and runtime data are stored outside the Git repository.

## Verification
Required checks: authenticated PING, Laravel Redis connection, cache put/get,
TTL behavior, lock acquisition, secret scan, and normal PostgreSQL health.
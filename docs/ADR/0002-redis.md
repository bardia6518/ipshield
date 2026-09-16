# ADR-0002 — Redis

Decision: Redis is used for cache, queue, rate limiting, temporary locks, and short-lived state.

Failure principle: Redis failure must not corrupt PostgreSQL. Degraded behavior must fail safely.

# Observability Foundation

Health dimensions are reported independently:
- application
- PostgreSQL
- Redis
- queue/workers
- scheduler

## Health endpoint
`GET /api/v1/health` exposes a structured snapshot for every dimension.
Core availability is based on application + PostgreSQL + Redis.
Queue/scheduler diagnostics are reported independently so operational warnings stay visible without hiding the core dependency state.

## Queue signal
The snapshot exposes the number of persisted failed jobs.
A non-zero count is reported as `attention`; operators can inspect details with Laravel failed-job tooling.

## Scheduler signal
The scheduler probe writes its last successful UTC execution timestamp into Redis.
The health endpoint exposes that timestamp when available.

## Minimum staging/production alerts
- application unavailable
- PostgreSQL unavailable
- Redis unavailable
- persistent failed jobs
- scheduler probe missing/stale
- disk pressure
- abnormal error rate

Logging is evidence, not monitoring. External alert delivery is a deployment concern and is not coupled to Phase 2 application code.

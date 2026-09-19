# Scheduler Foundation

Scheduler runtime: Laravel Scheduler.
Application timezone: UTC.

## Foundation probe
Command: `ipshield:scheduler-probe`
Frequency: every minute.
The probe writes a short-lived UTC marker to Redis and emits a structured log entry.

## Safety
Scheduled tasks must be idempotent or dispatch idempotent queue jobs.
Long-running/heavy work belongs in Redis queues, not inside scheduler callbacks.
All production schedules must use overlap protection where duplicate execution is unsafe.

Current probe uses:
- `withoutOverlapping(5)`
- `onOneServer()`
- a named schedule mutex backed by the shared cache

## Local development
Use `scripts/scheduler-local.ps1` for continuous local scheduling.
Use `scripts/scheduler-local.ps1 -Once` for QA and smoke tests.

No Windows Task Scheduler service is installed in Phase 2.
This keeps local setup reversible and avoids OS-level changes.

## Production model
Production Linux will invoke `php artisan schedule:run` every minute using cron or an equivalent supervisor.
Only one scheduler trigger is required per environment; Laravel coordinates per-task locks through the shared cache.

## Future Phase 3+ candidates
- threat-feed synchronization
- cleanup/archive work
- risk recalculation dispatch
- statistics aggregation
- health/maintenance probes

Business schedules are intentionally not implemented in Phase 2.

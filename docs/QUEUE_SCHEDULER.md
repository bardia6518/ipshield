# Queue & Scheduler Foundation

Queue transport: Redis.

Future queued work:
- threat feed processing
- IP enrichment
- risk recalculation
- evidence processing
- file import
- notifications
- external synchronization

Rules:
- jobs must be idempotent when retries are possible
- tries and timeouts must be explicit for expensive jobs
- failed jobs must be persisted and observable
- heavy work must not run synchronously in HTTP handlers

Scheduler candidates:
- feed sync
- cleanup/archive
- risk recalculation
- statistics
- health checks

Scheduled tasks must be logged and safe against overlapping runs.

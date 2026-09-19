# Security Baseline

## Transport and runtime
- HTTPS only in production.
- `APP_DEBUG=false` in production.
- Secrets remain outside Git and are injected per environment.
- Public errors never expose SQL, filesystem paths, credentials or stack traces.

## API controls
- Laravel Sanctum is the Phase 2 token-authentication foundation.
- API rate limiter: 60 requests/minute per authenticated identity or client IP.
- CORS uses an explicit origin allow-list from `CORS_ALLOWED_ORIGINS`.
- API inputs use validation and field allow-lists.

## Response headers
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `Referrer-Policy: strict-origin-when-cross-origin`
- HSTS is added only for secure production requests.

## Data and uploads
- Uploads require size, type and content controls.
- Never trust original filenames.
- Security-sensitive administrative changes require audit events.
- Dependency additions require governance review.

## Phase boundary
Phase 2 installs and configures security primitives only.
Registration/login flows, authorization policies and production token issuance are implemented with their product features in later phases.

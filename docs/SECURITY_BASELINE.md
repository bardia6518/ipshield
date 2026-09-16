# Security Baseline

- HTTPS only in production.
- `APP_DEBUG=false` in production.
- Restrictive CORS allow-list.
- CSRF policy depends on first-party session usage.
- API routes are rate-limited.
- Inputs use validation and allow-lists.
- Uploads require size/type/content controls.
- Never trust original filenames.
- Secrets stay outside Git.
- Public errors never expose SQL, paths, credentials or stack traces.
- Security-sensitive admin changes create audit events.
- Dependencies are reviewed before addition.

Recommended headers:
- `X-Content-Type-Options: nosniff`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `X-Frame-Options: DENY` unless a documented embed case exists.

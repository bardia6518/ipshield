# Logging & Error Handling

## Log channels
IPShield keeps operational categories physically separated.

### System
Exceptions, database failures, worker failures and integration failures.
Channel: `system` -> `storage/logs/system.log`.

### Security
Suspicious requests, abuse, rate-limit breaches and authentication anomalies.
Channel: `security` -> `storage/logs/security.log`.

### Audit
Who performed what action, against which target, and when.
Channel: `audit` -> `storage/logs/audit.log`.

Audit/security events must not be mixed with general application logs.

## Sensitive context
`LogContextSanitizer` recursively redacts known credential fields including passwords, tokens, Authorization values, secrets and API keys.
Raw credentials must never be intentionally logged.

## Error taxonomy
- VALIDATION_ERROR
- AUTHENTICATION_ERROR
- AUTHORIZATION_ERROR
- NOT_FOUND
- CONFLICT
- RATE_LIMITED
- BUSINESS_ERROR
- DEPENDENCY_ERROR
- INTERNAL_ERROR

Production responses must never expose stack traces, SQL, secrets or filesystem paths.
Central exception-to-API mapping is completed in Step 2.13.

# Logging & Error Handling

Logging is separated into three categories:

## System logs
Exceptions, database failures, worker failures, integration failures.

## Security events
Suspicious requests, abuse, rate-limit breaches, authentication anomalies.

## Audit logs
Who performed what action, against which target, and when.

Audit logs must not be mixed with normal application logs.

Error taxonomy:
- VALIDATION_ERROR
- AUTHENTICATION_ERROR
- AUTHORIZATION_ERROR
- NOT_FOUND
- CONFLICT
- RATE_LIMITED
- BUSINESS_ERROR
- DEPENDENCY_ERROR
- INTERNAL_ERROR

Production responses must never expose stack traces, SQL, secrets, or filesystem paths.

# ADR-0003 — REST API

Decision: backend/public contract uses versioned REST endpoints under `/api/v1`.

Reasons:
- broad client compatibility
- predictable HTTP semantics
- straightforward rate limiting and observability
- suitable for IP lookup/report workflows

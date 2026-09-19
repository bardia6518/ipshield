# Backend Architecture

Target flow:
`HTTP -> Validation -> Application -> Domain -> Infrastructure -> PostgreSQL`

## Layer responsibilities
- HTTP: transport only; controllers remain thin.
- Validation: explicit request validation and allow-lists.
- Application: use-case orchestration through contracts.
- Domain: business rules and domain exceptions without framework persistence details.
- Infrastructure: database, Redis, filesystem and external adapters.
- PostgreSQL remains the source of truth; Redis is auxiliary.

## Dependency rule
Higher-level application/domain code must not depend directly on Laravel persistence details.
Framework adapters implement contracts owned by the Application layer.
The Phase 2 `TransactionManager` contract and Laravel implementation are the baseline example.

## Planned modules
- Identity
- IP Intelligence
- Reputation
- Reporting
- Collector
- API Platform
- Audit

Frontend remains decoupled from Laravel and communicates through `/api/v1`.
Phase 2 establishes boundaries only; Phase 3 owns business behavior.

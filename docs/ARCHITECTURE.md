# Backend Architecture

Target flow:
`HTTP -> Validation -> Application/Service -> Domain -> Data Access -> PostgreSQL`

Rules:
- Controllers stay thin.
- Validation is explicit and allow-list based.
- Business logic belongs in application/domain services.
- Persistence details stay outside controllers.
- Redis is auxiliary; PostgreSQL remains the source of truth.

Future modules:
- Identity
- IP Intelligence
- Reputation
- Reporting
- Collector
- API Platform
- Audit

Frontend remains decoupled from Laravel and communicates through `/api/v1`.

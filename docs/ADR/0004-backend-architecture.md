# ADR-0004 — Backend Architecture

Decision: controllers remain thin.

Flow:
`HTTP -> Validation -> Application/Service -> Domain -> Data Access -> PostgreSQL`

Future modules: Identity, IP Intelligence, Reputation, Reporting, Collector, API Platform, Audit.

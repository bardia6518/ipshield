# ADR-0001 — PostgreSQL

Decision: PostgreSQL is the primary operational database.

Reasons:
- native `INET` for IPv4/IPv6
- `JSONB` for selected flexible threat payloads
- mature indexing and partitioning
- strong query capabilities for threat-intelligence workloads

# Database Governance

Primary database: PostgreSQL.

Standards:
- IP columns use PostgreSQL `INET`.
- Flexible threat payloads may use `JSONB` where justified.
- Timestamps are stored in UTC.
- Use snake_case, explicit foreign keys and reviewed migrations.

Append-only candidates:
- `ip_reputation_history`
- `threat_events`
- `threat_evidence`
- `audit_logs`
- `source_reputation_history`
- `user_reputation_history`

Deletion policy:
- history/security records are archived or corrected by new records.
- mutable entities may use soft delete.
- raw collector data follows a retention policy.

Production destructive rollback requires backup and impact review.

# Database Governance

Primary database: PostgreSQL. All persisted timestamps are UTC.

## 1. Data classes

### Mutable data
Mutable tables represent current state and may be updated when business rules allow it.
Examples include current user/account state, current IP profile state, source configuration,
API key state, tenant configuration, and other operational settings.

Mutable entities may use `deleted_at` when recovery/history is required.
Hard delete is not the default for business or security-relevant records.

### Append-only data
The following domains are append-only by default:
- `ip_reputation_history`
- `threat_events`
- `threat_evidence`
- `audit_logs`
- `source_reputation_history`
- `user_reputation_history`

Corrections to append-only data are represented by a new record, not by rewriting history.
## 2. Soft delete policy

Use soft delete for mutable records when deletion must remain recoverable or auditable.
Do not use soft delete as a substitute for append-only history.
Queries for active records must explicitly respect `deleted_at`.
Permanent deletion requires an explicit retention or legal rule.

## 3. Archive and retention

Archive policy is separate from deletion policy.
Security/history records remain queryable or archived without silently losing provenance.
No automatic hard-delete period is assumed unless a table-specific retention rule is documented.
Raw collector payloads may receive a bounded retention period once their integrity metadata,
source, processing result, and required evidence are safely retained.

Before any purge job exists, it must define scope, age rule, exclusions, dry-run behavior,
logging, failure behavior, and recovery path.

## 4. Audit requirements

Security-sensitive state changes must produce an application audit record containing actor,
action, target, timestamp, and relevant request/context identifiers.
Audit records are not ordinary application logs and are append-only.
## 5. Migration safety

Every schema change must be reviewed before merge.
Prefer additive migrations: add nullable/new structure, backfill, switch reads/writes, then enforce constraints.
Dropping columns/tables, narrowing types, destructive renames, or rewriting large tables requires an impact review.
Production destructive changes require a verified backup and a forward recovery plan.

`down()` must be implemented when a safe rollback exists.
If rollback is unsafe or lossy, the migration must document that and use a forward-fix strategy instead.
Migration rollback must never be used as an unreviewed production data-recovery mechanism.

## 6. Naming and integrity

Use snake_case names, explicit foreign keys, appropriate indexes, and PostgreSQL-native types where required.
IP addresses use `INET`; flexible threat payloads may use `JSONB` when justified.
Foreign-key delete behavior must be explicit; security/history records must not disappear through accidental cascades.

## 7. Governance gate

Before merge/deploy:
1. migration files pass static governance checks;
2. secrets are not committed;
3. migrations run successfully on PostgreSQL;
4. tests pass;
5. destructive migrations receive explicit review and backup planning.
# PostgreSQL Foundation

Primary operational database: PostgreSQL.

## Phase 2 decisions
- PostgreSQL 18 is the local development baseline.
- Database name: `ipshield`.
- Application role: `ipshield_app`.
- The application role is not a superuser and cannot create databases or roles.
- Local PostgreSQL listens only on `127.0.0.1:5432`.
- Authentication uses SCRAM-SHA-256.
- Database and application timestamps use UTC.
- IP data uses PostgreSQL `INET` where applicable.
- Flexible threat payloads may use `JSONB` where justified.

## Laravel
- `DB_CONNECTION=pgsql`.
- Real credentials live only in ignored `.env` files.
- Migrations are the source of truth for schema changes.
- SQLite is not an operational database for IPShield.

## Local runtime
Portable PostgreSQL is used on the current Windows development machine.
Use `scripts/postgres-local-start.ps1` and `scripts/postgres-local-stop.ps1`.
Staging and Production will use their own PostgreSQL instances and secrets.

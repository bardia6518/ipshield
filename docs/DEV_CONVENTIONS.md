# Development Conventions

- PHP follows PSR-12 and Laravel conventions.
- Classes use PascalCase; methods/variables use camelCase.
- Database names use snake_case.
- Every external input is validated.
- Controllers do not contain core business logic.
- New dependencies require review and documentation.
- Important changes require tests.
- Production code must not depend on Windows-only paths.
- Store timestamps in UTC.
- Use PostgreSQL `INET` for IP addresses.
- Use `JSONB` only for justified flexible payloads.
- Never commit credentials or secrets.

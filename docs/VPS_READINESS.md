# Linux / VPS Readiness

Production target:
- Linux
- Nginx
- PHP-FPM
- PostgreSQL
- Redis
- queue worker process manager
- scheduler
- TLS

Rules:
- no Windows-only runtime dependency
- application paths must be portable
- secrets are injected per environment
- workers and scheduler must survive restarts
- DirectAdmin may remain for DNS/domain/email, not the IPShield core runtime

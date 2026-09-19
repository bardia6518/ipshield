# Linux / VPS Readiness

Production/staging target:
- Linux
- Nginx
- PHP-FPM 8.3+
- PostgreSQL
- Redis
- systemd-managed queue worker
- systemd-managed Laravel scheduler
- TLS termination

## Repository templates
- `infra/nginx/ipshield.conf.example`
- `infra/systemd/ipshield-queue.service`
- `infra/systemd/ipshield-scheduler.service`
- `scripts/staging-readiness.sh`

The templates assume the release path `/var/www/ipshield`.
Adjust the PHP-FPM socket to the PHP version installed on the target VPS.

## Staging environment requirements
- `APP_ENV=staging`
- `APP_DEBUG=false`
- unique `APP_KEY`
- PostgreSQL via `DB_CONNECTION=pgsql`
- Redis cache and queue
- environment-specific database/Redis credentials
- production-like TLS and hostname
- writable Laravel storage/bootstrap cache directories

Secrets are injected on the server and are never copied from tracked templates.

## Deployment order
1. provision PHP/Nginx/PostgreSQL/Redis or managed equivalents
2. clone/fetch the approved Git revision
3. install Composer dependencies with production options
4. inject staging `.env`
5. run `php artisan migrate --force`
6. cache production configuration/routes where appropriate
7. validate `/api/v1/health`
8. enable/restart worker and scheduler services
9. verify logs and failed-job visibility

## Operational rules
- no Windows-only runtime dependency is required by application code
- DirectAdmin may remain for DNS/domain/email, not IPShield core runtime
- queue workers and scheduler must survive host restarts
- database and evidence backups must be defined before production launch
- rollback uses the previous application release plus a reviewed database rollback/forward-fix plan
- never run destructive migration/database commands as part of unattended deployment

Phase 2 verifies readiness artifacts only; it does not perform a live staging or production deployment.

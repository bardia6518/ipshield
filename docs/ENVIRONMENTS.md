# Environment Architecture

## Local
- Development only
- Debug may be enabled
- Local PostgreSQL/Redis
- No production data

## Staging
- Linux VPS target
- Separate PostgreSQL, Redis and secrets
- Non-production data only

## Production
- Linux + Nginx + PHP-FPM
- Dedicated PostgreSQL user/database
- Dedicated Redis credentials
- `APP_DEBUG=false`
- HTTPS only

Secrets never belong in Git. Each environment has independent DB, Redis,
application keys, mail credentials, API secrets and feed credentials.

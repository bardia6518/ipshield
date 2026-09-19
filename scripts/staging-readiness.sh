#!/usr/bin/env bash
set -euo pipefail

ROOT="${1:-$(cd "$(dirname "$0")/.." && pwd)}"
BACKEND="$ROOT/backend"
FAIL=0

pass(){ printf 'PASS: %s\n' "$1"; }
fail(){ printf 'FAIL: %s\n' "$1"; FAIL=1; }

for cmd in php git; do
  command -v "$cmd" >/dev/null 2>&1 && pass "$cmd available" || fail "$cmd missing"
done

[ -f "$BACKEND/artisan" ] && pass "Laravel backend present" || fail "Laravel backend missing"
[ -f "$BACKEND/.env" ] && pass ".env present" || fail ".env missing"

if [ -f "$BACKEND/.env" ]; then
  grep -q '^APP_ENV=staging$' "$BACKEND/.env" && pass "APP_ENV=staging" || fail "APP_ENV must be staging"
  grep -q '^APP_DEBUG=false$' "$BACKEND/.env" && pass "APP_DEBUG=false" || fail "APP_DEBUG must be false"
  grep -q '^DB_CONNECTION=pgsql$' "$BACKEND/.env" && pass "PostgreSQL configured" || fail "PostgreSQL required"
  grep -q '^CACHE_STORE=redis$' "$BACKEND/.env" && pass "Redis cache configured" || fail "Redis cache required"
  grep -q '^QUEUE_CONNECTION=redis$' "$BACKEND/.env" && pass "Redis queue configured" || fail "Redis queue required"
fi

if [ "$FAIL" -eq 0 ]; then
  (
    cd "$BACKEND"
    php artisan about >/dev/null
    php artisan migrate:status >/dev/null
    php artisan route:list --path=api/v1 >/dev/null
    php artisan schedule:list >/dev/null
  ) && pass "Laravel runtime checks" || fail "Laravel runtime checks"
fi

if git -C "$ROOT" ls-files | grep -E '(^|/)\.env$|\.pem$|id_rsa|id_ed25519' >/dev/null; then
  fail "potential secret tracked"
else
  pass "secret tracking check"
fi

if [ "$FAIL" -eq 0 ]; then
  echo "STAGING_READINESS=PASS"
  exit 0
fi

echo "STAGING_READINESS=FAIL"
exit 1

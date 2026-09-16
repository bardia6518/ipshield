#!/usr/bin/env bash
set -u
ROOT="${1:-$(pwd)}"
BACKEND="$ROOT/backend"
FAIL=0
pass(){ echo "PASS: $1"; }
fail(){ echo "FAIL: $1"; FAIL=1; }

[ -f "$BACKEND/artisan" ] && pass "Laravel backend" || fail "Laravel backend"
[ -f "$ROOT/docs/API_STANDARDS.md" ] && pass "API docs" || fail "API docs"
[ -f "$ROOT/infra/compose.yaml" ] && pass "infra compose" || fail "infra compose"

if command -v php >/dev/null 2>&1; then
  php "$BACKEND/artisan" --version >/dev/null && pass "artisan boot" || fail "artisan boot"
else
  fail "PHP executable"
fi

if [ -f "$BACKEND/.env" ]; then
  grep -q '^DB_CONNECTION=pgsql$' "$BACKEND/.env" && pass "PostgreSQL env" || fail "PostgreSQL env"
  grep -q '^QUEUE_CONNECTION=redis$' "$BACKEND/.env" && pass "Redis queue env" || fail "Redis queue env"
fi

if command -v git >/dev/null 2>&1 && [ -d "$ROOT/.git" ]; then
  if git -C "$ROOT" ls-files | grep -E '(^|/)\.env$|\.pem$|id_rsa|id_ed25519' >/dev/null; then
    fail "potential secret tracked"
  else
    pass "secret tracking check"
  fi
fi

(cd "$BACKEND" && php artisan test) && pass "test suite" || fail "test suite"

if [ "$FAIL" -eq 0 ]; then
  echo "PHASE2_VERIFY=PASS"
else
  echo "PHASE2_VERIFY=FAIL"
  exit 1
fi

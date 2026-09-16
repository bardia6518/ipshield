param([string]$ProjectRoot = "C:\Projects\ipshield")
$ErrorActionPreference = "Continue"
$failed = $false
function Pass($m) { Write-Host "PASS: $m" }
function Fail($m) { Write-Host "FAIL: $m"; $script:failed = $true }

$backend = Join-Path $ProjectRoot "backend"
if (Test-Path (Join-Path $backend "artisan")) { Pass "Laravel backend" } else { Fail "Laravel backend" }
if (Test-Path (Join-Path $ProjectRoot "docs\API_STANDARDS.md")) { Pass "API docs" } else { Fail "API docs" }
if (Test-Path (Join-Path $ProjectRoot "infra\compose.yaml")) { Pass "infra compose" } else { Fail "infra compose" }

php (Join-Path $backend "artisan") --version
if ($LASTEXITCODE -eq 0) { Pass "artisan boot" } else { Fail "artisan boot" }

$envPath = Join-Path $backend ".env"
if (Test-Path $envPath) {
    $envText = Get-Content $envPath -Raw
    if ($envText -match '(?m)^DB_CONNECTION=pgsql$') { Pass "PostgreSQL env" } else { Fail "PostgreSQL env" }
    if ($envText -match '(?m)^QUEUE_CONNECTION=redis$') { Pass "Redis queue env" } else { Fail "Redis queue env" }
    if ($envText -match '(?m)^CACHE_STORE=redis$') { Pass "Redis cache env" } else { Fail "Redis cache env" }
}

$git = "C:\Tools\PortableGit\cmd\git.exe"
if (Test-Path $git) {
    $tracked = & $git -C $ProjectRoot ls-files 2>$null
    $bad = $tracked | Select-String -Pattern '(^|/)\.env$|\.pem$|id_rsa|id_ed25519'
    if ($bad) { Fail "potential secret tracked" } else { Pass "secret tracking check" }
} else { Fail "Git executable" }

Push-Location $backend
php artisan test
if ($LASTEXITCODE -eq 0) { Pass "test suite" } else { Fail "test suite" }
Pop-Location

if ($failed) {
    Write-Host "PHASE2_VERIFY=FAIL"
    exit 1
}
Write-Host "PHASE2_VERIFY=PASS"

param([string]$ProjectRoot = "C:\Projects\ipshield")

$ErrorActionPreference = 'Stop'
$migrations = Join-Path $ProjectRoot 'backend\database\migrations'
if (-not (Test-Path $migrations)) { throw 'MIGRATIONS_DIR_NOT_FOUND' }

$dangerous = @(
  'dropColumn\s*\(',
  'dropIfExists\s*\(',
  'Schema::drop\s*\(',
  'renameColumn\s*\(',
  'change\s*\('
)

$hits = @()
Get-ChildItem $migrations -File -Filter '*.php' | ForEach-Object {
  $text = Get-Content $_.FullName -Raw
  $upOnly = ($text -split 'public\s+function\s+down\s*\(', 2)[0]
  foreach ($pattern in $dangerous) {
    if ($upOnly -match $pattern) { $hits += "$($_.Name): $pattern" }
  }
}

if ($hits.Count -gt 0) {
  Write-Host 'DB_GOVERNANCE_REVIEW=REQUIRED'
  $hits | ForEach-Object { Write-Host $_ }
  exit 2
}

Write-Host 'DB_GOVERNANCE_CHECK=PASS'
exit 0
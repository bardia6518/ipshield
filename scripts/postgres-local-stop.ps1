$ErrorActionPreference = 'Stop'
$base = if ($env:IPSHIELD_PG_HOME) { $env:IPSHIELD_PG_HOME } else { 'C:\Tools\PostgreSQL18.6' }
$bin = Join-Path $base 'pgsql\bin'
$data = Join-Path $base 'data'

if (-not (Test-Path (Join-Path $bin 'pg_ctl.exe'))) {
    throw "PostgreSQL binaries not found at $bin"
}

& (Join-Path $bin 'pg_ctl.exe') -D $data stop -m fast
if ($LASTEXITCODE -ne 0) {
    throw 'PostgreSQL stop failed.'
}

Write-Host 'IPSHIELD_POSTGRES=STOPPED'

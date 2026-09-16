$ErrorActionPreference = 'Stop'
$base = if ($env:IPSHIELD_PG_HOME) { $env:IPSHIELD_PG_HOME } else { 'C:\Tools\PostgreSQL18.6' }
$bin = Join-Path $base 'pgsql\bin'
$data = Join-Path $base 'data'
$log = Join-Path $base 'postgresql.log'

if (-not (Test-Path (Join-Path $bin 'pg_ctl.exe'))) {
    throw "PostgreSQL binaries not found at $bin"
}

& (Join-Path $bin 'pg_ctl.exe') -D $data -l $log start
Start-Sleep -Seconds 2
& (Join-Path $bin 'pg_isready.exe') -h 127.0.0.1 -p 5432
if ($LASTEXITCODE -ne 0) {
    throw 'PostgreSQL did not become ready.'
}

Write-Host 'IPSHIELD_POSTGRES=READY'

$ErrorActionPreference = 'Stop'
$base = 'C:\Tools\MemuraiDeveloper'
$cli = Join-Path $base 'tools\memurai-cli.exe'
$secret = Join-Path $base 'private\redis.secret'

if (-not (Get-NetTCPConnection -LocalPort 6379 -State Listen -ErrorAction SilentlyContinue)) {
    Write-Host 'REDIS_ALREADY_STOPPED=YES'
    exit 0
}

$env:REDISCLI_AUTH = (Get-Content $secret -Raw).Trim()
& $cli -h 127.0.0.1 -p 6379 SHUTDOWN SAVE
Start-Sleep -Seconds 1
if (Get-NetTCPConnection -LocalPort 6379 -State Listen -ErrorAction SilentlyContinue) {
    Write-Host 'REDIS_STOP=FAIL'
    exit 1
}

Write-Host 'REDIS_STOP=PASS'
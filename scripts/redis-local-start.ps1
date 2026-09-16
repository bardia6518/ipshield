$ErrorActionPreference = 'Stop'
$base = 'C:\Tools\MemuraiDeveloper'
$exe = Join-Path $base 'tools\memurai.exe'
$cli = Join-Path $base 'tools\memurai-cli.exe'
$conf = Join-Path $base 'ipshield.conf'
$secret = Join-Path $base 'private\redis.secret'

if (Get-NetTCPConnection -LocalPort 6379 -State Listen -ErrorAction SilentlyContinue) {
    Write-Host 'REDIS_ALREADY_RUNNING=YES'
    exit 0
}

Start-Process -FilePath $exe -ArgumentList ('"' + $conf + '"') -WindowStyle Hidden
Start-Sleep -Seconds 2
if (-not (Get-NetTCPConnection -LocalPort 6379 -State Listen -ErrorAction SilentlyContinue)) {
    Write-Host 'REDIS_START=FAIL'
    exit 1
}

$env:REDISCLI_AUTH = (Get-Content $secret -Raw).Trim()
& $cli -h 127.0.0.1 -p 6379 PING
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }
Write-Host 'REDIS_START=PASS'
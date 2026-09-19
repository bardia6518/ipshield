$ErrorActionPreference = 'Stop'
$backend = 'C:\Projects\ipshield\backend'

Set-Location $backend

composer validate --no-check-publish
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }

composer audit --locked
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }

$json = composer show --direct --format=json | ConvertFrom-Json
$abandoned = @($json.installed | Where-Object { $_.abandoned -eq $true })

if ($abandoned.Count -gt 0) {
    Write-Host 'ABANDONED_DIRECT_DEPENDENCIES=FAIL'
    $abandoned | ForEach-Object { Write-Host $_.name }
    exit 2
}

Write-Host 'ABANDONED_DIRECT_DEPENDENCIES=PASS'
Write-Host 'DEPENDENCY_AUDIT=PASS'

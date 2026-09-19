param([switch]$Once)

$ErrorActionPreference = 'Stop'
$backend = 'C:\Projects\ipshield\backend'

Set-Location $backend
php artisan config:clear | Out-Null

$args = @(
    'artisan', 'queue:work', 'redis',
    '--queue=ipshield:queue:default',
    '--sleep=1',
    '--tries=3',
    '--timeout=30',
    '--memory=256'
)

if ($Once) {
    $args += '--max-jobs=1'
} else {
    $args += '--max-time=3600'
}

& php @args
exit $LASTEXITCODE

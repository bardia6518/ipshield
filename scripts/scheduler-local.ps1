param([switch]$Once)

$ErrorActionPreference = 'Stop'
$backend = 'C:\Projects\ipshield\backend'

Set-Location $backend
php artisan config:clear | Out-Null

if ($Once) {
    php artisan schedule:run
} else {
    php artisan schedule:work
}

exit $LASTEXITCODE

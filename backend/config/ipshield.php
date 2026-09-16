<?php

return [
    'api_version' => env('IPSHIELD_API_VERSION', 'v1'),
    'timezone' => env('IPSHIELD_DEFAULT_TIMEZONE', 'UTC'),
    'health' => [
        'check_database' => true,
        'check_redis' => true,
    ],
];

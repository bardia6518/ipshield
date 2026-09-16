<?php

return [
    'api_version' => env('IPSHIELD_API_VERSION', 'v1'),
    'timezone' => env('IPSHIELD_DEFAULT_TIMEZONE', 'UTC'),
    'health' => [
        'check_database' => true,
        'check_redis' => true,
    ],
    'redis' => [
        'namespaces' => [
            'cache' => env('IPSHIELD_REDIS_CACHE_PREFIX', 'ipshield:cache:'),
            'queue' => env('IPSHIELD_REDIS_QUEUE_PREFIX', 'ipshield:queue:'),
            'rate_limit' => env('IPSHIELD_REDIS_RATE_LIMIT_PREFIX', 'ipshield:rate-limit:'),
            'lock' => env('IPSHIELD_REDIS_LOCK_PREFIX', 'ipshield:lock:'),
        ],
        'default_ttl_seconds' => env('IPSHIELD_REDIS_DEFAULT_TTL', 300),
    ],
];
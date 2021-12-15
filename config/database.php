<?php

return [
    'connections' => [
        'remote' => [
            'driver' => 'mysql',
            'host' => env('DB_REMOTE_HOST', '127.0.0.1'),
            'port' => env('DB_REMOTE_PORT', 3306),
            'database' => env('DB_REMOTE_DATABASE', 'forge'),
            'username' => env('DB_REMOTE_USERNAME', 'forge'),
            'password' => env('DB_REMOTE_PASSWORD', ''),
            'unix_socket' => env('DB_REMOTE_SOCKET', ''),
            'charset' => env('DB_REMOTE_CHARSET', 'utf8mb4'),
            'collation' => env('DB_REMOTE_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_REMOTE_PREFIX', ''),
            'strict' => env('DB_REMOTE_STRICT_MODE', true),
            'engine' => env('DB_REMOTE_ENGINE', null),
            'timezone' => env('DB_REMOTE_TIMEZONE', '+00:00'),
        ],
    ],
];

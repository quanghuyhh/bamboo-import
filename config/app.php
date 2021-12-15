<?php

return [
    'services' => [
        'auth' => [
            'base_url' => env('AUTH_SERVICE_BASE_URL', 'http://api-auth/'),
            'paths' => [
                'user' => 'users/',
            ],
            'headers' => [
                'user_uuid' => env('AUTH_HEADER_UUID', 'X-AUTH-UUID'),
                'user_permissions' => env('AUTH_FORWARD_USER_PERMISSIONS', 'X-AUTH-PERMISSIONS'),
                'account_holder_id' => env('FORWARDED_DATA_ACCOUNT_HOLDER_ID', 'X-Data-Account-Holder-Id'),
            ],
        ],
        'portal' => [
            'base_url' => env('PORTAL_SERVICE_BASE_URL', 'http://api-portal/'),
            'storage_url' => env('PORTAL_SERVICE_STORAGE_URL', ''),
            'paths' => [
                'organization' => 'organizations/',
                'license_type' => 'license-types/',
                'license' => 'licenses/',
                'user' => 'users/',
            ],
        ],
        'trace' => [
            'base_url' => env('TRACE_SERVICE_BASE_URL', 'http://api-trace/'),
            'paths' => [
                'strain' => 'internal/strains/',
            ],
        ],
    ],
];

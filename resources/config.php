<?php

return [
    'app-id' => env('SSO_MANAGER_MAIN_APP_ID', ''),
    'table' => env('SSO_MANAGER_DB_TABLE', 'applications'),
    'connection' => env('SSO_MANAGER_DB_CONNECTION', 'sso_manager_db'),
    'config' => [
        'driver' => 'sqlsrv',
        'url' => null,
        'host' => env('SSO_MANAGER_DB_HOST', 'localhost'),
        'port' => env('SSO_MANAGER_DB_PORT', '1433'),
        'database' => env('SSO_MANAGER_DB_DATABASE', 'forge'),
        'username' => env('SSO_MANAGER_DB_USERNAME', 'forge'),
        'password' => env('SSO_MANAGER_DB_PASSWORD', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
    ],
];

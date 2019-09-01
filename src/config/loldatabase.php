<?php
return [
    'connections' => [
        'loldatabase' => [
            'driver' => 'mysql',
            'host' => env('LOL_DATABASE_HOST', env('DB_HOST')),
            'port' => env('DB_PORT', '3306'),
            'database' => env('LOL_DATABASE_DATABASE', 'forge'),
            'username' => env('LOL_DATABASE_USERNAME', 'forge'),
            'password' => env('LOL_DATABASE_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
    ],
];

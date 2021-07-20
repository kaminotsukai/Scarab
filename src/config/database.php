<?php

return [

    'default' => 'mysql',

    'connections' => [

        'mysql' => [
            'dns' => 'mysql:host=mariadb; dbname=test; charset=utf8mb4',
            'driver' => 'mysql',
            'host' => '127.0.0.3',
            'port' => 3306,
            'database' => 'test',
            'username' => 'test',
            'password' => 'password',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
        ]
    ]
];

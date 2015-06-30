<?php

if (ENV == 'dev') {
    return [
        'database_type' => 'mysql',
        'database_name' => '',
        'server' => 'localhost',
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ],
    ];
} elseif (ENV == 'pro') {
    return [
        'database_type' => 'mysql',
        'database_name' => '',
        'server' => 'localhost',
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ],
    ];
} else {
    return false;
}

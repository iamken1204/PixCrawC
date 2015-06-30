<?php

$serverEnv = 'dev';
$baseUrl = '';

if(!defined('ENV') && $serverEnv == 'dev')
    define('ENV', 'dev');
if(!defined('ENV') && $serverEnv == 'pro')
    define('ENV', 'pro');

if (!defined('BASE_URL'))
    define('BASE_URL', $baseUrl);

return [
    'env' => $serverEnv,
    'baseUrl' => $baseUrl,
    'basePath' => dirname(__DIR__),
    'db' => require("db.php"),
    'viewCookieName' => 'find21bearV',
];

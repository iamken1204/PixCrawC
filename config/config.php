<?php

$serverEnv = 'dev';
$baseUrl = 'http://dev.cronnos.cc';

if(!defined('ENV') && $serverEnv == 'dev')
    define('ENV', 'dev');
if(!defined('ENV') && $serverEnv == 'pro')
    define('ENV', 'pro');

if (!defined('BASE_URL'))
    define('BASE_URL', $baseUrl);

$basePath = dirname(__DIR__);

return [
    'env' => $serverEnv,
    'baseUrl' => $baseUrl,
    'basePath' => $basePath,
    'viewPath' => $basePath . '/views/',
    'defaultLayout' => 'default_layout.php',
    'defaultLayoutPath' => $basePath . '/views/layouts/',
    'title' => 'DEV Cronnos',
    'db' => require("db.php"),
    'viewCookieName' => 'CronnosV',
];

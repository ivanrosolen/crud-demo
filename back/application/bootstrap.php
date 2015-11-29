<?php

date_default_timezone_set('America/Sao_Paulo');

session_start();

define('SETTINGS_INI',  realpath(__DIR__ ). '/config/settings.ini');

define('APP_SESSION',  'CRUD_DEMO_APP');

define('TYPE_ADM',     'ADM');
define('TYPE_USER',    'USER');

if (!$config = parse_ini_file(SETTINGS_INI, true)) {
    throw new Exception('Unable to open settings file');
}

header('Access-Control-Allow-Origin: ' . $config['config']['host']);
header('Access-Control-Allow-Methods: POST, GET, PUT, REMOVE');
header('Content-Type: application/json; charset=utf-8');

require_once realpath(__DIR__ . '/../vendor/autoload.php');

require_once realpath(__DIR__) . '/routes.php';

echo $router->dispatch()->response();

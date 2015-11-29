<?php

date_default_timezone_set('America/Sao_Paulo');

define('SETTINGS_INI',  realpath(__DIR__ ). '/config/settings.ini');

if (!$config = parse_ini_file(SETTINGS_INI, true)) {
    throw new Exception('Unable to open settings file');
}

header('Access-Control-Allow-Origin: ' . $config['config']['host']);
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Authorization');
header('Content-Type: application/json; charset=utf-8');

if( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ) {
    return true;
}

require_once realpath(__DIR__ . '/../vendor/autoload.php');

require_once realpath(__DIR__) . '/routes.php';

echo $router->dispatch()->response();

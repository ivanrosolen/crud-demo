<?php

use Respect\Rest\Router;
use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\Response as Response;
use Xuplau\CRUD\User\Check as UserCheck;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

$base = '';

$router = new Router($base);

$router->post('/user/login',  'Xuplau\CRUD\User\Login');
$router->get('/user/logout',  'Xuplau\CRUD\User\Logout');

$router->get('/list/infos/*/*/*', 'Xuplau\CRUD\Info\ListAll');

$router->get('/info/*',  'Xuplau\CRUD\Info\Crud');
$router->post('/info',   'Xuplau\CRUD\Info\Crud');
$router->put('/info',    'Xuplau\CRUD\Info\Crud');
$router->delete('/info', 'Xuplau\CRUD\Info\Crud');

$router->any('/*', function () { return 'CRUD Demo!'; });

$jsonRender = function ($data) {
    header('Content-Type: application/json; charset=utf-8');
    if ( v::ResponseString()->validate($data) ) {
        $data = array($data);
    }
    return json_encode($data, true);
};

$loginCheck = function() use ($router) {

    if (!$config = parse_ini_file(SETTINGS_INI, true)) {
        return Response::Internal_Server_Error('Falha no login');
    }

    // get token
    $headers = getallheaders();
    $token = str_replace('Bearer ', '', $headers['Authorization']);

    $userCheck = new UserCheck;
    $login     = $userCheck->isValid( $token );

    if ( $login === false ) {
        return Response::Unauthorized();
    }

    if ( empty($token) && !in_array($router->request->uri, array( '/user/login', '/user/logout' )) ) {

        $parser = new Parser;
        $token = $parser->parse($token);

        $data = new ValidationData;
        $data->setIssuer($config['jwt']['issuer']);
        $data->setAudience($config['jwt']['audience']);
        $data->setId($config['jwt']['id'], true);

        if ( (bool) $token->validate($data) !== true ) {
            echo Response::Unauthorized();
            return false;
        }
    }
    return true;
};

$router->always('Accept', array('application/json' => $jsonRender));
$router->always('By', $loginCheck);
<?php

use Respect\Rest\Router;
use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\Response as Response;
use Xuplau\CRUD\User\Check as UserCheck;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;


// host path http://host/path/to/public/
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
        echo Response::Internal_Server_Error('Falha no login');
        return false;
    }

    if ( !in_array($router->request->uri, array( '/user/login', '/user/logout' )) ) {

        // get token
        $headers = getallheaders();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $userCheck = new UserCheck;
        $login     = $userCheck->isValid( $token );

        if ( empty($token) ) {
            echo Response::Unauthorized();
            return false;
        }

        if ( $login === false ) {
            echo Response::Unauthorized();
            return false;
        }

        $parser = new Parser;
        $token = $parser->parse($token);

        $data = new ValidationData;
        $data->setIssuer($config['jwt']['issuer']);
        $data->setAudience($config['jwt']['audience']);

        // unique id - blacklist
        $data->setId( hash('sha256', $config['jwt']['key'].$login->hash), true) ;

        $signer = new Sha256;

        // validate() and verify() returns BOOL
        if ( $token->validate($data) !== true ||
             $token->verify($signer, $config['jwt']['key']) !== true )
        {
            echo Response::Unauthorized();
            return false;
        }
    }
    return true;
};

$router->always('Accept', array('application/json' => $jsonRender));
$router->always('By', $loginCheck);
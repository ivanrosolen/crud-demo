<?php

use Respect\Rest\Router;
use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\Response as Response;

$base = '/back';

$router = new Router($base);

$router->post('/user/login',  'Xuplau\CRUD\User\Login');
$router->get('/user/logout',  'Xuplau\CRUD\User\Logout');

$router->get('/list/infos/*/*', 'Xuplau\CRUD\Info\ListAll');

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

    if ( $router->request->uri != '/user/login' &&
        ( !isset($_SESSION[APP_SESSION]) ||
           empty($_SESSION[APP_SESSION]) ||
           !is_object($_SESSION[APP_SESSION]) ||
           !isset($_SESSION[APP_SESSION]->hash) ||
           empty($_SESSION[APP_SESSION]->hash) )
    ) {
        echo Response::Unauthorized();
        return false;
    }
    return true;
};

$router->always('Accept', array('application/json' => $jsonRender));
$router->always('By', $loginCheck);
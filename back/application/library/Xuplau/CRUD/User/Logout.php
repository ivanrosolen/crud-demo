<?php
Namespace Xuplau\CRUD\User;

use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\Response as Response;
use Xuplau\Database\MapperDB;
use Respect\Rest\Routable;

Class Logout extends MapperDB implements Routable
{
    public function get() {
        return Response::OK();
    }
}
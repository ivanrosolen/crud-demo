<?php
Namespace Xuplau\CRUD\User;

use Xuplau\Database\MapperDB;
use Xuplau\CRUD\Validation as v;
use Lcobucci\JWT\Parser;
use Exception;
use stdClass;

Class Check extends MapperDB
{

    public function isValid( $token ) {

        try {

            $parser = new Parser;
            $token  = $parser->parse($token);
            $hash   = $token->getClaim('uid');

            $login = $this->getMapper()
                          ->user(array('hash'=>$hash,'status'=>1))
                          ->fetch();
            if ( !$login ) {
                return false;
            }

        } catch ( PDOException $e ) {
            return false;
        }  catch ( Exception $e ) {
            return false;
        }

        return $login;
    }

}
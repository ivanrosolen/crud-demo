<?php
Namespace Xuplau\CRUD\User;

use Xuplau\Database\MapperDB;
use Xuplau\CRUD\Validation as v;
use Exception;
use stdClass;

Class Check extends MapperDB
{

    public function isValid() {

        try {

            $login = $this->getMapper()
                          ->user(array('hash'=>$_SESSION[APP_SESSION]->hash,'status'=>1))
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
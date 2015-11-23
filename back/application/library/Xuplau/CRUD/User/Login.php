<?php
Namespace Xuplau\CRUD\User;

use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\Response as Response;
use Xuplau\Database\MapperDB;
use Respect\Rest\Routable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use PDOException;
use Exception;
use stdClass;

Class Login extends MapperDB implements Routable
{

    public function post() {

        if (!isset($_POST['user']) || empty($_POST['user']) ||
            !isset($_POST['pwd'])  || empty($_POST['pwd'])) {
            return response::Bad_Request(array('Faltam parâmetros'));
        }

        $user = filter_var( $_POST['user'], FILTER_SANITIZE_STRING );
        $pwd  = filter_var( $_POST['pwd'],  FILTER_SANITIZE_STRING );

        if ( !v::Login()->validate( array('user' => $user, 'pwd' => $pwd)) ) {
            return Response::Bad_Request('Parâmetros inválidos');
        }

        try {

            $login = $this->getMapper()
                          ->user(array('login'=>$user,'pwd'=>hash('sha256',$pwd),'status'=>1))
                          ->fetch();

            if ( !$login ) {
                return Response::No_Content('Nenhum login encontrado');
            }

        } catch ( PDOException $e ) {
            return Response::Internal_Server_Error('Falha no login');
        }  catch ( Exception $e ) {
            return Response::Internal_Server_Error('Falha no login');
        }

        $tmp          = new stdClass;
        $tmp->name    = $login->name;
        $tmp->hash    = $login->hash;

        if (!$config = parse_ini_file(SETTINGS_INI, true)) {
            return Response::Internal_Server_Error('Falha no login');
        }

        $builder = new Builder;
        $signer  = new Sha256;
        $token   = $builder->setIssuer($config['jwt']['issuer'])
                           ->setAudience($config['jwt']['audience'])
                           ->setId($config['jwt']['id'], true)
                           ->setIssuedAt(time())
                           ->setNotBefore(time() + 60)
                           ->setExpiration(time() + 3600)
                           ->set('uid', 1)
                           ->sign($signer, $config['jwt']['key'])
                           ->getToken();

        return Response::OK( $token );
    }
}
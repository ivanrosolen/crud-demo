<?php
Namespace Xuplau\CRUD\Info;

use Xuplau\Database\MapperDB;
use Xuplau\CRUD\Response as Response;
use Xuplau\CRUD\Validation as v;
use Xuplau\CRUD\User\Check as UserCheck;
use Respect\Relational\Sql;
use Respect\Rest\Routable;
use PDOException;
use Exception;
use DateTime;
use stdClass;

Class Crud extends MapperDB implements Routable
{

    public function get( $hash ) {

        $hash = filter_var( $hash, FILTER_SANITIZE_STRING );

        if ( empty($hash) || !v::InfoHash()->validate($hash) ) {
            return Response::Bad_Request('Parâmetro inválido');
        }

        try {

            $info = $this->getMapper()
                        ->info(array('hash' => $hash))
                        ->user
                        ->fetch();
            if ( !$info ) {
                return Response::No_Content('Nenhum registro encontrado');
            }

        } catch ( PDOException $e) {
            return Response::Internal_Server_Error('Falha algo na PDO');
        }  catch ( Exception $e) {
            return Response::Internal_Server_Error('Falha algo no PHP');
        }

        $info->user       = $info->user_id->name;
        $info->field_date = date('d/m/Y', strtotime($info->field_date));
        unset($info->id);
        unset($info->user_id);

        return Response::OK($info);

    }

    public function post() {

        $text = filter_var( $_POST['field_text'], FILTER_SANITIZE_STRING );
        $date = filter_var( $_POST['field_date'], FILTER_SANITIZE_STRING );
        $hash = filter_var( $_POST['hash'],       FILTER_SANITIZE_STRING );

        if ( empty($text) || !v::InfoText()->validate($text) ) {
            return Response::Bad_Request('Parâmetro Texto inválido');
        }

        if ( !empty($date) && !v::InfoData()->validate($date) ) {
            return Response::Bad_Request('Parâmetro Data inválido');
        }
        $date = DateTime::createFromFormat('d/m/Y', $date);

        if ( empty($hash) || !v::InfoHash()->validate($hash) ) {
            return Response::Bad_Request('Parâmetro inválido');
        }

        try {

            $login = $this->getMapper()
                          ->user(array('hash'=>$hash,'status'=>1))
                          ->fetch();
            if ( !$login ) {
                return Response::Unprocessable_Entity('Erro ao validar usuário');
            }

            $info             = new StdClass;
            $info->hash       = hash('sha256',$text+time());
            $info->field_text = $text;
            $info->field_date = $date->format('Y-m-d');
            $info->created    = date('Y-m-d H:i:s');
            $info->user_id    = $login->id;

            $this->getMapper()->info->persist($info);
            $this->getMapper()->flush();

        } catch ( PDOException $e) {
            return Response::Internal_Server_Error('Falha algo na PDO');
        }  catch ( Exception $e) {
            return Response::Internal_Server_Error('Falha algo no PHP');
        }

        return Response::OK(array('newHash' => $info->hash));

    }

    public function put() {

        parse_str(file_get_contents('php://input'), $vars);

        $hash = filter_var( $vars['hashId'], FILTER_SANITIZE_STRING );

        if ( empty($hash) || !v::InfoHash()->validate($hash) ) {
            return Response::Bad_Request('Parâmetro inválido');
        }

        try {

            $info = $this->getMapper()
                    ->info(array('hash' => $hash))
                    ->fetch();

            if ( !$info ) {
                return Response::Unprocessable_Entity('Erro ao validar registro');
            }

            $text = filter_var( $vars['field_text'], FILTER_SANITIZE_STRING );
            $date = filter_var( $vars['field_date'], FILTER_SANITIZE_STRING );

            if ( empty($text) || !v::InfoText()->validate($text) ) {
                return Response::Bad_Request('Parâmetro Texto inválido');
            }

            if ( !empty($date) && !v::InfoData()->validate($date) ) {
                return Response::Bad_Request('Parâmetro Data inválido');
            }
            $date = DateTime::createFromFormat('d/m/Y', $date);

            $info->hash       = hash('sha256',$text+time());
            $info->field_text = $text;
            $info->field_date = $date->format('Y-m-d');;

            $this->getMapper()->info->persist($info);
            $this->getMapper()->flush();

        } catch ( PDOException $e) {
            return Response::Internal_Server_Error('Falha algo na PDO');
        }  catch ( Exception $e) {
            return Response::Internal_Server_Error('Falha algo no PHP');
        }

        return Response::OK(array('newHash' => $info->hash));

    }

    public function delete() {

        parse_str(file_get_contents('php://input'), $vars);

        $hash = filter_var( $vars['hashId'], FILTER_SANITIZE_STRING );

        if ( empty($hash) ) {
            return Response::Bad_Request('Parâmetro inválido');
        }

        try {

            $info = $this->getMapper()
                         ->info(array('hash' => $hash))
                         ->fetch();

            if ( !$info ) {
                return Response::Unprocessable_Entity('Erro ao validar registro');
            }

            $this->getMapper()->info->remove($info);
            $this->getMapper()->flush();

        } catch ( PDOException $e) {
            return Response::Internal_Server_Error('Falha algo na PDO');
        }  catch ( Exception $e) {
            return Response::Internal_Server_Error('Falha algo no PHP');
        }

        return Response::OK('Registro Removido');

    }
}
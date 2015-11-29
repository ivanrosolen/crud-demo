<?php
Namespace Xuplau\CRUD\Info;

use Xuplau\Database\MapperDB;
use Xuplau\CRUD\Response as Response;
use Xuplau\CRUD\User\Check as UserCheck;
use Respect\Relational\Sql;
use Respect\Rest\Routable;
use PDOException;
use Exception;
use stdClass;

Class ListAll extends MapperDB implements Routable
{

    public function get( $pagina = 0, $search = 'all' ) {

        $pagination = 2;

        $where  = array();
        $pagina = filter_var( $pagina, FILTER_SANITIZE_NUMBER_INT );
        $pag    = ($pagina == 1) ? '0' : ($pagina*$pagination)-$pagination;
        $search = filter_var( urldecode($search), FILTER_SANITIZE_STRING );

        if ( $search != 'all' ) {
            $where = array("field_text LIKE \"%{$search}%\"");
        }

        $sql = Sql::orderBy('field_date')->asc();

        try {

            // Todo: fix this pagination thing
            $infos = $this->getMapper()
                          ->info($where)
                          ->fetchAll($sql);
            $total = count($infos);

            if ( count($total) == 0 ) {
                return Response::No_Content('Nenhum registro encontrado');
            }

        } catch ( PDOException $e ) {

            return Response::Internal_Server_Error(array('Falha no sistema'));
        }  catch ( Exception $e ) {
            return Response::Internal_Server_Error(array('Falha no sistema'));
        }

        $sql   = $sql->limit($pag,$pagination);
        $infos = $this->getMapper()
                     ->info($where)
                     ->user
                     ->fetchAll($sql);

        $total_pags = ceil($total / $pagination);

        $tmp        = new stdClass;
        $tmp->pag   = $pagina;
        $tmp->total = $total_pags;
        $tmp->list  = $infos;

        foreach ($tmp->list as $key => $obj) {
            $obj->user       = $obj->user_id->name;
            $obj->field_date = date('d/m/Y', strtotime($obj->field_date));
            unset($obj->id);
            unset($obj->user_id);
        }

        return Response::OK($tmp);
    }
}
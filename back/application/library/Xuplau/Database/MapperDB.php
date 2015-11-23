<?php
Namespace Xuplau\Database;

use Respect\Relational\Mapper;
use Respect\Relational\DB as Database;

Class MapperDB
{

    private $mapper = null;
    private $db     = null;

    public function __construct() {
        $this->getMapper();
    }

    public function getMapper() {

        if(!$this->mapper instanceof Mapper) {
            $this->mapper = new Mapper(new DB());
        }

        $this->mapper->exec("SET NAMES 'utf8'");
        $this->mapper->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->mapper->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

        return $this->mapper;
    }
}
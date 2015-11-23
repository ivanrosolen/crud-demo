<?php
Namespace Xuplau\Database;


Class DB extends \PDO
{

    public function __construct($file = SETTINGS_INI) {

        if (!$config = parse_ini_file($file, true)) {
            throw new \Exception('Unable to open settings file');
        }

        $dsn = 'mysql:host='.$config['db']['db_server'].';dbname='.$config['db']['db_name'];

        parent::__construct($dsn, $config['db']['db_user'], $config['db']['db_pwd']);

    }
}
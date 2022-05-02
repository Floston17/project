<?php

namespace core\Database;

use PDO;

class Connection
{
    /**
     * Creates instance of PDO class.
     */
    public static function make($path)
    {
        $config = (require $path)['database'];
        try {
            return new PDO($config['dbms'] . ':host=' . $config['host'] . '; dbname=' . $config['dbname'] . ';',
                $config['user'],
                $config['password'],
                $config['options']
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
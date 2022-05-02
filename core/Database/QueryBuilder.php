<?php

namespace core\Database;

use App\Exceptions\DbException;
use PDO;

class QueryBuilder
{
    protected PDO $dbh;
    protected static $instance = null;

    protected function __construct($pdo)
    {
        $this->dbh = $pdo;
    }

    /**
     * Singleton
     */
    public static function instance($pdo): QueryBuilder
    {
        if (static::$instance == null) {
            return new self($pdo);
        } else {
            return static::$instance;
        }
    }

    /**
     * Returns table records satisfying exact query.
     */
    public function query(string $statement, string $class, array $data = []): array
    {
        $sth = $this->dbh->prepare($statement);
        $res = $sth->execute($data);
        if (!$res) {
            throw new DbException('Ошибка при выполнении запроса: ' . $statement);
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    /**
     * Execute sql query - INSERT, DELETE, UPDATE (without fetching anything)
     */
    public function execute($statement, $data = []): bool
    {
        $sth = $this->dbh->prepare($statement);
        $res = $sth->execute($data);
        if (!$res) {
            throw new DbException('Ошибка при выполнении запроса: ' . $statement);
        }
        return $res;
    }

    /**
     * Returns last inserted id.
     */
    public function lastInsertId()
    {
        $res = $this->dbh->lastInsertId();
        if (!$res) {
            throw new DbException('Ошибка при выполнении запроса');
        }
        return $res;
    }
}
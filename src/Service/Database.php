<?php

namespace MaximKravets\OOP\Service;

use LogicException;
use PDO;

class Database
{
    /**
     * @var PDO
     */
    private $pdo;
    private static $instance = null;

    private function __construct()
    {
        $dbConfig = new DatabaseConfiguration();
        $this->pdo = $dbConfig->getConnection();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === false) {
            return null;
        }

        return $sth->fetchAll();
    }
}
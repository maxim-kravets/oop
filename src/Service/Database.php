<?php

namespace MaximKravets\OOP\Service;

use LogicException;
use PDO;
use Symfony\Component\Dotenv\Dotenv;

class Database
{
    /**
     * @var PDO
     */
    private $pdo;
    private static $instance = null;

    private function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(dirname(__DIR__).'/../.env');

        if (empty($_SERVER['DB_HOST'])) {
            throw new LogicException('DB_HOST can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['DB_NAME'])) {
            throw new LogicException('DB_NAME can\'t be empty. Fill it in .env');
        }

        if (empty($_SERVER['DB_USER'])) {
            throw new LogicException('DB_USER can\'t be empty. Fill it in .env');
        }

        $dsn = 'mysql://host='.$_SERVER['DB_HOST'].';dbname='.$_SERVER['DB_NAME'];

        $this->pdo = new PDO($dsn, $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
        $this->pdo->exec('SET NAMES utf8');
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
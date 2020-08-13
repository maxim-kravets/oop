<?php


namespace MaximKravets\OOP\Service;


use PDO;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Dotenv\Dotenv;

class DatabaseConfiguration
{
    private $pdo;

    public function __construct()
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

    public function getConnection()
    {
        return $this->pdo;
    }
}
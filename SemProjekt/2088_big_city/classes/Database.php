<?php

require_once __DIR__ . '/../db/config.php';

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $config = DATABASE;

        $dsn = 'mysql:host=' . $config['HOST']
             . ';port=' . $config['PORT']
             . ';dbname=' . $config['DBNAME']
             . ';charset=utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->connection = new PDO(
            $dsn,
            $config['USER_NAME'],
            $config['PASSWORD'],
            $options
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

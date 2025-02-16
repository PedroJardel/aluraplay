<?php

namespace alura\mvc\Infra;

use PDO;
use PDOException;

class Database
{
    private static?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dbPath = dirname(__DIR__, 2) . "/database.sqlite";
            try {
                self::$connection = new PDO("sqlite:$dbPath");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

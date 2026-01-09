<?php

namespace App\Core;

use PDO;

class Database
{
    // Singleton instance
    private static ?Database $instance = null;

    // PDO connection object
    private PDO $pdo;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,    // Throw exceptions on errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch results as associative arrays
            ]
        );
    }

    // Get the singleton Database instance
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database(); // Create instance if not exists
        }
        return self::$instance;
    }

    // Get PDO connection
    public function connection(): PDO
    {
        return $this->pdo;
    }
}

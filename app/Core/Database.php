<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Core\Logger;

class Database
{
    // Hold single instance of Database
    private static ?Database $instance = null;

    // PDO connection object
    private PDO $pdo;

    // Private constructor to prevent direct creation
    private function __construct()
    {
        try {
            // Create new PDO connection
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS,
                [
                    // Throw exceptions on errors
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    // Fetch data as associative array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {

            // Log database error
            Logger::error($e);

            // Show error in local environment
            if (defined('APP_ENV') && APP_ENV === 'local') {
                die('Database connection failed. Check logs.');
            }

            // Hide error in production
            http_response_code(500);
            exit;
        }
    }

    // Get single instance of Database
    public static function getInstance(): Database
    {
        // Create instance if not exists
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    // Return PDO connection
    public function connection(): PDO
    {
        return $this->pdo;
    }
}

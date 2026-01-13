<?php

namespace App\Middleware;

use App\Core\Logger;
use Exception;

class CsrfMiddleware
{
    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function verifyToken(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function protect(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? null;
            if (!self::verifyToken($token)) {
                $e = new Exception("Invalid CSRF token");
                Logger::error($e);
                throw $e;
            }
        }
    }
}

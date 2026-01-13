<?php

namespace App\Middleware;

use App\Core\Logger;
use Exception;

class AuthMiddleware
{
    /* -------------------------
       PROTECT
       Ensure page is accessible only to logged-in users
    ------------------------- */
    public static function protect(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (!isset($_SESSION['user'])) {
            Logger::error(new Exception("Unauthorized access attempt to protected page"));
            header('Location: /auth/login');
            exit; // redirect is ok
        }
    }

    /* -------------------------
       GUEST
       Ensure page is accessible only to guests
    ------------------------- */
    public static function guest(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (isset($_SESSION['user'])) {
            $dest = in_array('admin', $_SESSION['user']['roles'] ?? [])
                ? '/admin/dashboard'
                : '/auth/dashboard';
            header("Location: $dest");
            exit;
        }
    }

    /* -------------------------
       PROTECT ROLE
    ------------------------- */
    public static function protectRole(string $roleName): void
    {
        self::protect();

        if (!in_array($roleName, $_SESSION['user']['roles'] ?? [])) {
            $e = new Exception("Access denied: Role required -> $roleName");
            Logger::error($e);
            http_response_code(403);
            throw $e;
        }
    }

    /* -------------------------
       PROTECT PERMISSION
    ------------------------- */
        public static function protectPermission(string $permission): void
        {
            self::protect();

            $permissions = $_SESSION['user']['permissions'] ?? [];

            if (!in_array($permission, $permissions, true)) {
                $e = new Exception("Access denied: Permission required -> $permission");
                Logger::error($e);
                http_response_code(403);
                throw $e;
            }
        }


    /* -------------------------
       CHECK
    ------------------------- */
    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return isset($_SESSION['user']);
    }

    /* -------------------------
       IS GUEST
    ------------------------- */
    public static function isGuest(): bool
    {
        return !self::check();
    }
}

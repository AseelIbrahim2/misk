<?php


class AuthMiddleware
{
    // 🔹 Protect page for logged-in users
    public static function protect(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    // 🔹 Protect page for guests (not logged in)
    public static function guest(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (isset($_SESSION['user'])) {
            header('Location: /auth/dashboard');
            exit;
        }
    }

    // 🔹 Protect page by role
    public static function protectRole(string $roleName): void
    {
        self::protect(); // must be logged in
        if (!in_array($roleName, $_SESSION['user']['roles'] ?? [])) {
            header('HTTP/1.1 403 Forbidden');
            die("Access denied: Role required -> $roleName");
        }
    }

    // 🔹 Protect page by permission
    public static function protectPermission(string $permissionName): void
    {
        self::protect(); // must be logged in
        if (!in_array($permissionName, $_SESSION['user']['permissions'] ?? [])) {
            header('HTTP/1.1 403 Forbidden');
            die("Access denied: Permission required -> $permissionName");
        }
    }

    // 🔹 Helper: check if logged in
    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return isset($_SESSION['user']);
    }

    // 🔹 Helper: check if guest
    public static function isGuest(): bool
    {
        return !self::check();
    }
}

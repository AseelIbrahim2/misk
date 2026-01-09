<?php

namespace App\Middleware;

class AuthMiddleware
{
    /* -------------------------
       PROTECT
       Ensure page is accessible only to logged-in users
    ------------------------- */
    public static function protect(): void
    {
        // Start session if not active
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Check if user session exists
        if (!isset($_SESSION['user'])) {
            // If not logged in, redirect to login page
            header('Location: /auth/login');
            exit;
        }
        // If logged in, execution continues to the page
    }

    /* -------------------------
       GUEST
       Ensure page is accessible only to guests (not logged-in users)
    ------------------------- */
    public static function guest(): void
    {
        // Start session if not active
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Check if user session exists (logged in)
        if (isset($_SESSION['user'])) {
            // If user has admin role, redirect to admin dashboard
            if (in_array('admin', $_SESSION['user']['roles'])) {
                header('Location: /admin/dashboard');
                exit;
            }

            // Otherwise, redirect to regular user dashboard
            header('Location: /auth/dashboard');
            exit;
        }
        // If not logged in, execution continues to the guest page
    }

    /* -------------------------
       PROTECT ROLE
       Restrict page access based on a specific role
    ------------------------- */
    public static function protectRole(string $roleName): void
    {
        self::protect(); // Must be logged in first

        // Check if user has the required role
        if (!in_array($roleName, $_SESSION['user']['roles'] ?? [])) {
            // If not, send 403 Forbidden and stop execution
            header('HTTP/1.1 403 Forbidden');
            die("Access denied: Role required -> $roleName");
        }
        // If role matches, execution continues to the page
    }

    /* -------------------------
       PROTECT PERMISSION
       Restrict page access based on a specific permission
    ------------------------- */
    public static function protectPermission(string $permissionName): void
    {
        self::protect(); // Must be logged in first

        // Check if user has the required permission
        if (!in_array($permissionName, $_SESSION['user']['permissions'] ?? [])) {
            // If not, send 403 Forbidden and stop execution
            header('HTTP/1.1 403 Forbidden');
            die("Access denied: Permission required -> $permissionName");
        }
        // If permission exists, execution continues to the page
    }

    /* -------------------------
       CHECK
       Helper: Return true if user is logged in
    ------------------------- */
    public static function check(): bool
    {
        // Start session if not active
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Return whether user session exists
        return isset($_SESSION['user']);
    }

    /* -------------------------
       IS GUEST
       Helper: Return true if user is NOT logged in
    ------------------------- */
    public static function isGuest(): bool
    {
        // Simply invert the check() result
        return !self::check();
    }
}

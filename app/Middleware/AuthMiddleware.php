<?php

namespace App\Middleware;

use App\Core\Logger; // Logger class for logging errors or events
use Exception;       // PHP Exception class for error handling

class AuthMiddleware
{
    /* -------------------------
       PROTECT
       Ensure page is accessible only to logged-in users
    ------------------------- */
    public static function protect(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start(); 
        // Start session if not already started

        if (!isset($_SESSION['user'])) { 
            // Check if user is NOT logged in
            Logger::error(new Exception("Unauthorized access attempt to protected page")); 
            // Log unauthorized access attempt for monitoring

            header('Location: /auth/login'); 
            exit; // Redirect guest to login page
        }
    }

    /* -------------------------
       GUEST
       Ensure page is accessible only to guests
    ------------------------- */
    public static function guest(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start(); 
        // Start session if not already started

        if (isset($_SESSION['user'])) { 
            // If user is already logged in
            $dest = in_array('admin', $_SESSION['user']['roles'] ?? [])
                ? '/admin/dashboard' // Admin goes to admin dashboard
                : '/site/pages'; // Regular user goes to user dashboard
            header("Location: $dest"); 
            exit; // Redirect logged-in user away from guest-only pages
        }
    }

    /* -------------------------
       PROTECT ROLE
       Ensure user has a specific role to access page
    ------------------------- */
    public static function protectRole(string $roleName): void
    {
        self::protect(); 
        // First, ensure the user is logged in

        if (!in_array($roleName, $_SESSION['user']['roles'] ?? [])) { 
            // Check if user does NOT have the required role
            $e = new Exception("Access denied: Role required -> $roleName"); 
            Logger::error($e); 
            // Log the access denied event
            http_response_code(403); 
            // Send HTTP 403 Forbidden status
            throw $e; 
            // Throw exception to stop further execution
        }
    }

    /* -------------------------
       PROTECT PERMISSION
       Ensure user has a specific permission to access page
    ------------------------- */
    public static function protectPermission(string $permission): void
    {
        self::protect(); 
        // Ensure user is logged in first

        $permissions = $_SESSION['user']['permissions'] ?? []; 
        // Get current user's permissions

        if (!in_array($permission, $permissions, true)) { 
            // Check if required permission is missing
            $e = new Exception("Access denied: Permission required -> $permission"); 
            Logger::error($e); 
            // Log unauthorized access attempt
            http_response_code(403); 
            // Send HTTP 403 Forbidden status
            throw $e; 
            // Stop execution by throwing exception
        }
    }

    /* -------------------------
       CHECK
       Check if a user is logged in
    ------------------------- */
    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start(); 
        // Start session if not already started
        return isset($_SESSION['user']); 
        // Return true if user is logged in
    }

    /* -------------------------
       IS GUEST
       Check if current user is a guest (not logged in)
    ------------------------- */
    public static function isGuest(): bool
    {
        return !self::check(); 
        // Return true if user is NOT logged in
    }
}

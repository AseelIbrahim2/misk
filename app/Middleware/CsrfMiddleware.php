<?php

namespace App\Middleware;

use App\Core\Logger;  // Logger class to log errors or security issues
use Exception;        // PHP Exception class to throw errors

class CsrfMiddleware
{
    // Generate a CSRF token and store it in session
    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        // Ensure session is started to store token

        if (empty($_SESSION['csrf_token'])) {
            // If no token exists yet
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
            // Generate a 32-byte random token, convert to hex, store in session
        }

        return $_SESSION['csrf_token']; 
        // Return the CSRF token (used in forms)
    }

    // Verify that a provided CSRF token matches the one in session
    public static function verifyToken(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        // Ensure session is active

        return isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $token);
        // Compare the session token with provided token securely
        // hash_equals prevents timing attacks
    }

    // Protect a POST request by checking CSRF token
    public static function protect(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Only check CSRF token for POST requests
            $token = $_POST['csrf_token'] ?? null; 
            // Get token from POST data

            if (!self::verifyToken($token)) {
                // If token invalid or missing
                $e = new Exception("Invalid CSRF token"); 
                // Create an exception
                Logger::error($e); 
                // Log the invalid CSRF attempt for security
                throw $e; 
                // Stop execution and throw error
            }
        }
    }
}

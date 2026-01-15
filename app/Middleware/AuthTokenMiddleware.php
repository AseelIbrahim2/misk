<?php

namespace App\Middleware;

use App\Core\Logger;              // Logger class for logging errors or events
use App\Repositories\UserRepository; // UserRepository to access user data in DB
use Exception;                     // PHP Exception class for error handling

class AuthTokenMiddleware
{
    // Check if the provided auth token is valid
    public static function check(string $token): bool
    {
        $userRepo = new UserRepository(); 
        // Create instance of UserRepository to access users table

        $user = $userRepo->findUserByToken($token); 
        // Use repository method to find user by the given auth token

        if (!$user) { 
            // If no user found with this token
            Logger::error(new Exception("Invalid auth token attempt: $token")); 
            // Log this invalid token attempt for monitoring/security
        }

        return $user !== null; 
        // Return true if user exists (token valid), false otherwise
    }
}

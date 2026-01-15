<?php

namespace App\Controllers;

// Base controller class with common methods (like view rendering)
use App\Core\Controller;

// Service class handling all auth logic (register, login, logout)
use App\Services\AuthService;

// Middleware to protect routes for guests or logged-in users
use App\Middleware\AuthMiddleware;

// Middleware to protect against CSRF attacks
use App\Middleware\CsrfMiddleware;

use Exception; // PHP Exception class for error handling

class AuthController extends Controller
{
    protected AuthService $authService; // Service instance for authentication operations

    public function __construct()
    {
        $this->authService = new AuthService(); 
        // Initialize AuthService to handle login/register logic

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(); 
            // Start PHP session if not already started, needed for storing user data
        }
    }

    // Display login page and handle login POST
    public function login(): void
    {
        AuthMiddleware::guest(); 
        // Only allow guests (not logged-in users) to access login page

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::protect(); 
            // Check CSRF token to protect against cross-site request forgery

            $usernameOrEmail = $_POST['usernameOrEmail'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
            // Get login credentials from POST request

            try {
                $userData = $this->authService->login($usernameOrEmail, $password); 
                // Call AuthService to validate user credentials and login
                // Returns user data including roles and permissions

                // Role-based redirect
                if (in_array('admin', $_SESSION['user']['roles'])) {
                    header('Location: /admin/dashboard'); 
                    exit; // Redirect admins to admin dashboard
                }

                header('Location: /auth/dashboard'); 
                exit; // Redirect regular users to user dashboard

            } catch (Exception $e) {
                $this->view('auth/login', ['error' => $e->getMessage()]); 
                // If login fails, show login page with error message
                return;
            }
        }

        $this->view('auth/login'); 
        // If GET request, just display login form
    }

    // Display registration page and handle POST
    public function register(): void
    {
        AuthMiddleware::guest(); 
        // Only allow guests to access register page

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? ''; 
            $email    = $_POST['email'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
            // Get registration data from POST request

            try {
                $this->authService->register($username, $email, $password); 
                // Call AuthService to create a new user
                // Handles validation, hashing password, assigning default role, and storing session

                $userData = $this->authService->login($email, $password); 
                // Auto-login after registration, returns user data with roles/permissions

                // Store user data in session for authentication
                $_SESSION['user'] = [
                    'id'          => $userData['id'],
                    'username'    => $userData['username'],
                    'roles'       => $userData['roles'],
                    'permissions' => $userData['permissions']
                ];

                // Role-based redirect
                if (in_array('admin', $_SESSION['user']['roles'])) {
                    header('Location: /admin/dashboard'); 
                    exit; // Admin users go to admin dashboard
                }

                header('Location: /auth/dashboard'); 
                exit; // Regular users go to dashboard

            } catch (Exception $e) {
                $this->view('auth/register', ['error' => $e->getMessage()]); 
                // Show registration form with error message if registration fails
                return;
            }
        }

        $this->view('auth/register'); 
        // If GET request, just show registration form
    }

    // Logout user and destroy session
    public function logout(): void
    {
        AuthMiddleware::protect(); 
        // Only logged-in users can logout

        $_SESSION = []; 
        // Clear all session data

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params(); 
            setcookie(
                session_name(), '', time() - 42000, // Delete session cookie
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy(); 
        // Destroy session on server

        header('Location: /auth/login'); 
        exit; // Redirect to login page after logout
    }

    // Show user dashboard
    public function dashboard(): void
    {
        AuthMiddleware::protect(); 
        // Only allow logged-in users to access dashboard

        $this->view('auth/dashboard', [
            'username' => $_SESSION['user']['username']
        ]); 
        // Render dashboard view and pass username for display
    }
}

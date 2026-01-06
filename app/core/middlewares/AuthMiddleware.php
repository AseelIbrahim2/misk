<?php

class AuthMiddleware extends Middleware
{
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }
    }
}

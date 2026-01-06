<?php

class GuestMiddleware extends Middleware
{
    public function handle(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /auth/dashboard');
            exit;
        }
    }
}

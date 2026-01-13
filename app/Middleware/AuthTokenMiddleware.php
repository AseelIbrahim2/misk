<?php

namespace App\Middleware;

use App\Core\Logger;
use App\Repositories\UserRepository;
use Exception;

class AuthTokenMiddleware
{
    public static function check(string $token): bool
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findUserByToken($token);

        if (!$user) {
            Logger::error(new Exception("Invalid auth token attempt: $token"));
        }

        return $user !== null;
    }
}

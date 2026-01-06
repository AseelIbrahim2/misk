
<?php

// Config
require_once __DIR__ . '/config/database.php';

// Core
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/App.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';
require_once  __DIR__ . '/core/Validator.php';
require_once  __DIR__ . '/core/Middleware.php';

// Middlewares
require_once __DIR__ . '/core/middlewares/AuthMiddleware.php';
require_once __DIR__ . '/core/middlewares/GuestMiddleware.php';


// Models
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Role.php';
require_once __DIR__ . '/models/Permission.php';

// Repositories
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/repositories/RoleRepository.php';
require_once __DIR__ . '/repositories/PermissionRepository.php';

// Services
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/services/UserService.php';

<?php

session_start();

// Debug: show session
var_dump($_SESSION);

// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// If you still need init.php for configs
require_once __DIR__ . '/../app/init.php';

// Import App class with namespace
use App\Core\App;

// Create App instance
$app = new App();

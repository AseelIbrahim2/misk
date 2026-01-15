<?php

session_start();



// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

//need init.php for configs
require_once __DIR__ . '/../app/init.php';


// Import App class with namespace
use App\Core\App;



// Create App instance
$app = new App();

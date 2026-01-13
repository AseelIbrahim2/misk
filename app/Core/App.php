<?php

namespace App\Core;

// Main application class
// Responsible for routing the request
class App {

    // Default controller name
    protected $controller = 'HomeController';

    // Default method name
    protected $method = 'index';

    // URL parameters array
    protected $params = [];

    // App constructor runs on every request
    public function __construct() {

        // Parse URL and return it as array
        $url = $this->parseUrl();

        // Check if controller name exists in URL
        if (!empty($url[0])) {

            // Format controller name
            // Example: users → UsersController
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';

            // Check if controller file exists
            if (file_exists('../app/Controllers/' . $controllerName . '.php')) {

                // Set controller name
                $this->controller = $controllerName;

                // Remove controller from URL array
                unset($url[0]);
            }
        }

        // Build full controller class name with namespace
        $controllerClass = "App\\Controllers\\" . $this->controller;

        // Check if controller class exists
        if (class_exists($controllerClass)) {

            // Create controller object
            $this->controller = new $controllerClass();
        } else {

            // Throw error if controller not found
            throw new \Exception("Controller $controllerClass not found");
        }

        // Check if method exists in URL
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {

            // Set method name
            $this->method = $url[1];

            // Remove method from URL array
            unset($url[1]);
        }

        // Remaining URL values are parameters
        $this->params = $url ? array_values($url) : [];

        // Call controller method with parameters
        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );
    }

    // Parse URL from GET request
    public function parseUrl() {

        // Check if URL exists in query string
        if (isset($_GET['url'])) {

            // Remove last slash from URL
            $url = rtrim($_GET['url'], '/');

            // Sanitize URL to prevent attacks
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // Split URL into array by /
            return explode('/', $url);
        }

        // Return empty array if no URL provided
        return [];
    }
}

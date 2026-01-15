<?php

namespace App\Core;

// Main application class
// Handles routing and request dispatching
class App {

    // Default controller if none provided in URL
    protected $controller = 'HomeController';

    // Default method if none provided in URL
    protected $method = 'index';

    // Parameters extracted from URL
    protected $params = [];

    // Constructor runs on every request
    public function __construct() {

        // Parse URL into array parts
        $url = $this->parseUrl();
        

        // Check if controller name exists in URL
        if (!empty($url[0])) {

            // Format controller name
            // Example: news → NewsController
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';

            // Check if controller file exists
            if (file_exists('../app/Controllers/' . $controllerName . '.php')) {

                // Set controller
                $this->controller = $controllerName;

                // Remove controller part from URL
                unset($url[0]);
            }
        }

        // Build full controller class with namespace
        $controllerClass = "App\\Controllers\\" . $this->controller;

        // Ensure controller class exists
        if (class_exists($controllerClass)) {

            // Instantiate controller
            $this->controller = new $controllerClass();
        } else {

            // Stop execution if controller not found
            throw new \Exception("Controller $controllerClass not found");
        }

        // Check if method exists in URL and controller
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {

            // Set method name
            $this->method = $url[1];

            // Remove method from URL
            unset($url[1]);
        }


        // Remaining URL parts are parameters
        $this->params = $url ? array_values($url) : [];

        // Call controller method with parameters
        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );

        
    }

    // Parse URL from query string
    public function parseUrl() {

        // Check if URL parameter exists
        if (isset($_GET['url'])) {

            // Remove trailing slash
            $url = rtrim($_GET['url'], '/');

            // Sanitize URL to prevent attacks
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // Split URL into array
            return explode('/', $url);
        }

        // Return empty array if no URL
        return [];
    }
}

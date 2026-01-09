<?php

namespace App\Core;

class App {

    // Default controller
    protected $controller = 'HomeController';

    // Default method
    protected $method = 'index';

    // URL parameters
    protected $params = [];

    public function __construct() {

        // Parse URL into array
        $url = $this->parseUrl();

        // Check if controller exists in URL
        if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';

            // Check controller file existence
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]); // Remove controller from URL
            }
        }

        // Load controller file
        $controllerClass = "App\\Controllers\\" . $this->controller;

        if (class_exists($controllerClass)) {
            $this->controller = new $controllerClass();
        } else {
            throw new \Exception("Controller $controllerClass not found");
        }
        

        // Check if method exists in URL
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]); // Remove method from URL
        }

        // Remaining URL parts as parameters
        $this->params = $url ? array_values($url) : [];

        // Call controller method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {

        // Check if URL parameter exists
        if (isset($_GET['url'])) {

            // Remove trailing slash
            $url = rtrim($_GET['url'], '/');

            // Sanitize URL
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // Split URL into parts
            return explode('/', $url);
        }

        // Return empty array if no URL
        return [];
    }
}

?>

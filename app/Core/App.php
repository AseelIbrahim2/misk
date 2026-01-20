<?php

namespace App\Core;

class App {

    protected $controller = 'SiteHomeController'; // Default Site controller
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        $url = $this->parseUrl();

        // -----------------------------
        // 1. Handle AuthController
        // -----------------------------
        if (!empty($url[0]) && strtolower($url[0]) === 'auth') {
            $this->loadRootController($url);
            return;
        }

        // -----------------------------
        // 2. Detect Controller
        // -----------------------------
if (!empty($url[0])) {
    $name = ucfirst($url[0]); // NewsPage
    $possibleController = $name . "Controller"; // NewsPageController
    $controllerPath = "../app/Controllers/{$possibleController}.php";

    if (file_exists($controllerPath)) {
        $this->controller = $possibleController;
        unset($url[0]);
    }
}

        // -----------------------------
        // 3. Build Controller Class
        // -----------------------------
        $controllerClass = "App\\Controllers\\{$this->controller}";
        $controllerPath = "../app/Controllers/{$this->controller}.php";

        if (!class_exists($controllerClass)) {
            if (!file_exists($controllerPath)) {
                throw new \Exception("Controller {$controllerClass} not found");
            }
            require_once $controllerPath;
        }

        $controllerInstance = new $controllerClass();

        // -----------------------------
        // 4. Detect Method
        // -----------------------------
        if (!empty($url[1]) && method_exists($controllerInstance, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // -----------------------------
        // 5. Remaining Params
        // -----------------------------
        $this->params = $url ? array_values($url) : [];

        // Call controller method
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function loadRootController(array $url): void
    {
        $controller = 'AuthController';
        $method = $url[1] ?? 'index';
        $controllerPath = "../app/Controllers/{$controller}.php";

        if (!file_exists($controllerPath)) {
            throw new \Exception("Controller {$controller} not found");
        }

        require_once $controllerPath;

        $controllerClass = "App\\Controllers\\{$controller}";
        $instance = new $controllerClass();

        call_user_func([$instance, $method]);
    }

    public function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}

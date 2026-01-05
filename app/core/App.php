<?php

class App {

    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // تحقق من وجود controller في URL
           if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])).'Controller';

            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }


        // استدعاء ملف الكنتورلر
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // تحقق من وجود method في URL
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // الباقي من الـ params
        $this->params = $url ? array_values($url) : [];

        // استدعاء الميثود مع الـ params
        call_user_func_array([$this->controller, $this->method], $this->params);

       
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        return [];
    }
}

?>

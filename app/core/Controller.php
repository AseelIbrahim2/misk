<?php

class Controller
{
    /**
     * Load a Model dynamically
     */
    public function model(string $modelName): ?object
    {
        $modelFile = __DIR__ . '/../models/' . $modelName . '.php';

        if (file_exists($modelFile) && class_exists($modelName, false) === false) {
            require_once $modelFile;

            if (class_exists($modelName)) {
                return new $modelName();
            }
        }

        return null;
    }

    /**
     * Load a View and pass data
     */
    public function view(string $viewName, array $data = []): void
    {
        $viewFile = __DIR__ . '/../views/' . $viewName . '.php';

        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            die("View '$viewName' not found.");
        }
    }

    /**
     * Apply middleware
     * Example: $this->middleware('auth');
     */
    protected function middleware(string $type): void
    {
        if (!class_exists('Middleware')) return;

        $mw = new Middleware();

        if ($type === 'auth') {
            $mw->auth();
        } elseif ($type === 'guest') {
            $mw->guest();
        }
    }
}

<?php

namespace App\Core;

abstract class Controller
{
    // Load a model dynamically and return its instance
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

    // Load a view file and pass optional data
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
}

<?php

namespace App\Core;

// Base abstract controller
// All controllers must extend this class
abstract class Controller
{
    // Load a model dynamically using Composer autoload
    public function model(string $modelName): ?object
    {
        // Build full class name with namespace
        $fullClass = "App\\Models\\" . $modelName;

        // Check if the class exists (Composer autoload will handle loading)
        if (class_exists($fullClass)) {

            // Instantiate and return the model
            return new $fullClass();
        }

        // Stop execution if model class not found
        throw new \Exception("Model '$fullClass' not found.");
    }

    // Load a view file and pass data to it
    public function view(string $viewName, array $data = []): void
    {
        // Build full path to view file
        $viewFile = __DIR__ . '/../Views/' . $viewName . '.php';

        // Check if view file exists
        if (file_exists($viewFile)) {

            // Convert array keys to variables for easy access in the view
            extract($data);

            // Include the view file to render it
            require $viewFile;

        } else {

            // Stop execution if view file not found
            throw new \Exception("View '$viewName' not found.");
        }
    }
}

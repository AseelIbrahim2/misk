<?php

namespace App\Core;

// Abstract base controller
abstract class Controller
{
    // Load a model dynamically
    public function model(string $modelName): ?object
    {
        // Build full path of the model file
        $modelFile = __DIR__ . '/../Models/' . $modelName . '.php';

        // Check if model file exists
        // Check if class is not already loaded
        if (file_exists($modelFile) && class_exists($modelName, false) === false) {

            // Include the model file
            require_once $modelFile;

            // Check if model class exists
            if (class_exists($modelName)) {

                // Create and return model instance
                return new $modelName();
            }
        }

        // Return null if model not found
        return null;
    }

    // Load a view file and pass data to it
    public function view(string $viewName, array $data = []): void
    {
        // Build full path of the view file
        $viewFile = __DIR__ . '/../Views/' . $viewName . '.php';

        // Check if view file exists
        if (file_exists($viewFile)) {

            // Convert array keys to variables
            extract($data);

            // Include the view file
            require_once $viewFile;
        } else {

            // Stop execution if view not found
            die("View '$viewName' not found.");
        }
    }
}

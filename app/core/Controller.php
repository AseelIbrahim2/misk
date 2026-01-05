

<?php

class Controller
{
    /**
     * Load a Model dynamically
     *
     * @param string $modelName
     * @return object|null
     */
    public function model(string $modelName): ?object
    {
        $modelFile = __DIR__ . '/../models/' . $modelName . '.php';

        if (file_exists($modelFile)) {
            require_once $modelFile;

            if (class_exists($modelName)) {
                return new $modelName();
            }
        }

        return null; // إذا الملف أو الكلاس غير موجود
    }

    /**
     * Load a View and pass data to it
     *
     * @param string $viewName
     * @param array $data
     * @return void
     */
    public function view(string $viewName, array $data = []): void
    {
        $viewFile = __DIR__ . '/../views/' . $viewName . '.php';

        if (file_exists($viewFile)) {
            // تحويل عناصر المصفوفة لمتغيرات
            extract($data);

            require_once $viewFile;
        } else {
            // يمكنك عمل صفحة خطأ أو استثناء
            die("View file '$viewName' not found.");
        }
    }
}

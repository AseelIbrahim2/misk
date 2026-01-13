<?php

namespace App\Core;

use Throwable;

class Logger
{
    /**
     * Log errors to storage/logs/app.log
     */
    public static function error(Throwable $e): void
    {
        // Define logs directory path
        $logDir = __DIR__ . '/../../storage/logs';

        // Create logs directory if not exists
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // Format error message
        $message = sprintf(
            "[%s] %s in %s:%d\nStack trace:\n%s\n\n",
            date('Y-m-d H:i:s'),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );

        // Write error to log file
        file_put_contents($logDir . '/app.log', $message, FILE_APPEND);
    }
}

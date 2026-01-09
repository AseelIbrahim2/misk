<?php

namespace App\Core;


class Validator
{
    // Store validation errors
    protected array $errors = [];

    /* -------------------------
       REQUIRED
    ------------------------- */
    // Check if field is not empty
    public function required(string $field, $value): void
    {
        if (empty(trim((string)$value))) {
            $this->errors[$field][] = "$field is required";
        }
    }

    /* -------------------------
       EMAIL
    ------------------------- */
    // Validate email format
    public function email(string $field, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Invalid email format";
        }
    }

    /* -------------------------
       MIN LENGTH
    ------------------------- */
    // Check minimum string length
    public function min(string $field, string $value, int $length): void
    {
        if (strlen($value) < $length) {
            $this->errors[$field][] = "$field must be at least $length characters";
        }
    }

    /* -------------------------
       PASSWORD 
    ------------------------- */
    // Validate password rules
    public function password(string $field, string $value, int $minLength = 6): void
    {
        if (strlen($value) < $minLength) {
            $this->errors[$field][] = "$field must be at least $minLength characters";
            return;
        }

        if (!preg_match('/[A-Za-z]/', $value)) {
            $this->errors[$field][] = "$field must contain at least one letter";
        }

        if (!preg_match('/[0-9]/', $value)) {
            $this->errors[$field][] = "$field must contain at least one number";
        }

        if (preg_match('/\s/', $value)) {
            $this->errors[$field][] = "$field must not contain spaces";
        }
    }

    /* -------------------------
       CHECK FAIL
    ------------------------- */
    // Check if validation failed
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /* -------------------------
       GET ERRORS
    ------------------------- */
    // Get all validation errors
    public function errors(): array
    {
        return $this->errors;
    }
}

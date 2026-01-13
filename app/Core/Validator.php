<?php

namespace App\Core;

class Validator
{
    // Store validation errors
    protected array $errors = [];

    // Check required field
    public function required(string $field, $value): void
    {
        if (empty(trim((string)$value))) {
            $this->errors[$field][] = "$field is required";
        }
    }

    // Validate email format
    public function email(string $field, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Invalid email format";
        }
    }

    // Check minimum length
    public function min(string $field, string $value, int $length): void
    {
        if (strlen($value) < $length) {
            $this->errors[$field][] = "$field must be at least $length characters";
        }
    }

    // Check maximum length
    public function max(string $field, string $value, int $length): void
    {
        if (strlen($value) > $length) {
            $this->errors[$field][] = "$field must not exceed $length characters";
        }
    }

    // Check if value is in allowed set
    public function in(string $field, $value, array $allowed): void
    {
        if (!in_array($value, $allowed, true)) {
            $this->errors[$field][] = "$field has an invalid value";
        }
    }

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

    // Sanitize input value
    public function sanitize(string $value): string
    {
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return $value;
    }

    // Check if validation failed
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    // Return all errors
    public function errors(): array
    {
        return $this->errors;
    }
}

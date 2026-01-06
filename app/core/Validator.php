<?php

class Validator
{
    protected array $errors = [];

    /* -------------------------
       REQUIRED
    ------------------------- */
    public function required(string $field, $value): void
    {
        if (empty(trim((string)$value))) {
            $this->errors[$field][] = "$field is required";
        }
    }

    /* -------------------------
       EMAIL
    ------------------------- */
    public function email(string $field, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Invalid email format";
        }
    }

    /* -------------------------
       MIN LENGTH
    ------------------------- */
    public function min(string $field, string $value, int $length): void
    {
        if (strlen($value) < $length) {
            $this->errors[$field][] = "$field must be at least $length characters";
        }
    }

    /* -------------------------
       PASSWORD (SECURE BUT SIMPLE)
    ------------------------- */
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
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /* -------------------------
       GET ERRORS
    ------------------------- */
    public function errors(): array
    {
        return $this->errors;
    }
}

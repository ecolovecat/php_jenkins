<?php

require_once __DIR__ . '/../config/Config.php';

class Validator
{
    private array $errors = [];

    public function validateRequired(string $field, $value, string $fieldName): bool
    {
        if (empty($value) || trim($value) === '') {
            $this->errors[$field] = "$fieldName is required";

            return false;
        }

        return true;
    }

    public function validateEmail(string $field, string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Please enter a valid email address";

            return false;
        }

        return true;
    }

    public function validateLength(string $field, string $value, int $min, int $max, string $fieldName): bool
    {
        $length = strlen($value);
        
        if ($length < $min || $length > $max) {
            $this->errors[$field] = "$fieldName must be between $min and $max characters";

            return false;
        }

        return true;
    }

    public function validatePassword(string $field, string $password): bool
    {
        $minLength = Config::MIN_PASSWORD_LENGTH;
        
        if (strlen($password) < $minLength) {
            $this->errors[$field] = "Password must be at least $minLength characters long";

            return false;
        }

        if (Config::PASSWORD_REQUIRE_LETTERS && !preg_match('/[A-Za-z]/', $password)) {
            $this->errors[$field] = "Password must contain at least one letter";

            return false;
        }

        if (Config::PASSWORD_REQUIRE_NUMBERS && !preg_match('/[0-9]/', $password)) {
            $this->errors[$field] = "Password must contain at least one number";

            return false;
        }

        return true;
    }

    public function validatePasswordMatch(string $field, string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            $this->errors[$field] = "Passwords do not match";

            return false;
        }

        return true;
    }

    public function validateUsername(string $field, string $username): bool
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $this->errors[$field] = "Username can only contain letters, numbers, and underscores";

            return false;
        }

        $minLength = Config::MIN_USERNAME_LENGTH;
        $maxLength = Config::MAX_USERNAME_LENGTH;
        
        if (strlen($username) < $minLength || strlen($username) > $maxLength) {
            $this->errors[$field] = "Username must be between $minLength and $maxLength characters";

            return false;
        }

        return true;
    }

    public function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public function sanitizeEmail(string $email): string
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }
} 
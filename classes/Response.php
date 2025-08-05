<?php

class Response
{
    private bool $success;
    private string $message;
    private array $data;
    private array $errors;

    public function __construct(bool $success = true, string $message = '', array $data = [], array $errors = [])
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setError(string $field, string $error): void
    {
        $this->errors[$field] = $error;
        $this->success = false;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors
        ];
    }

    public static function success(string $message = '', array $data = []): self
    {
        return new self(true, $message, $data);
    }

    public static function error(string $message = '', array $errors = []): self
    {
        return new self(false, $message, [], $errors);
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
} 
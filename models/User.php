<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Response.php';

class User
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register(string $username, string $password, string $email): Response
    {
        try {
            // Check if username already exists
            if ($this->findByUsername($username)) {
                return Response::error('Username already exists', ['username' => 'This username is already taken']);
            }

            // Check if email already exists
            if ($this->findByEmail($email)) {
                return Response::error('Email already exists', ['email' => 'This email is already registered']);
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, NOW())");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("sss", $username, $hashedPassword, $email);

            if ($stmt->execute()) {
                $userId = $this->conn->insert_id;
                $stmt->close();

                return Response::success('User registered successfully', ['user_id' => $userId]);
            }

            $stmt->close();

            return Response::error('Registration failed', ['general' => 'Unable to create user account']);

        } catch (Exception $e) {
            error_log("User registration error: " . $e->getMessage());

            return Response::error('Registration failed', ['general' => 'An error occurred during registration']);
        }
    }

    public function findByUsername(string $username): ?array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $result ?: null;

        } catch (Exception $e) {
            error_log("Error finding user by username: " . $e->getMessage());

            return null;
        }
    }

    public function findByEmail(string $email): ?array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $result ?: null;

        } catch (Exception $e) {
            error_log("Error finding user by email: " . $e->getMessage());

            return null;
        }
    }

    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $result ?: null;

        } catch (Exception $e) {
            error_log("Error finding user by ID: " . $e->getMessage());

            return null;
        }
    }

    public function authenticate(string $username, string $password): Response
    {
        try {
            $user = $this->findByUsername($username);

            if (!$user) {
                return Response::error('Invalid credentials', ['general' => 'Username or password is incorrect']);
            }

            if (!password_verify($password, $user['password'])) {
                return Response::error('Invalid credentials', ['general' => 'Username or password is incorrect']);
            }

            // Remove password from user data for security
            unset($user['password']);

            return Response::success('Login successful', ['user' => $user]);

        } catch (Exception $e) {
            error_log("Authentication error: " . $e->getMessage());

            return Response::error('Authentication failed', ['general' => 'An error occurred during login']);
        }
    }

    public function updateLastLogin(int $userId): bool
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();
            $stmt->close();

            return $result;

        } catch (Exception $e) {
            error_log("Error updating last login: " . $e->getMessage());

            return false;
        }
    }
}
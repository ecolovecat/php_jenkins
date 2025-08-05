<?php

require_once __DIR__ . '/Config.php';

class Database
{
    private static ?Database $instance = null;
    private ?mysqli $connection = null;

    private function __construct()
    {
        try {
            $this->connection = new mysqli(
                Config::DB_HOST,
                Config::DB_USERNAME,
                Config::DB_PASSWORD,
                Config::DB_NAME
            );

            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }

            $this->connection->set_charset(Config::DB_CHARSET);
        } catch (Exception $e) {
            if (Config::LOG_ERRORS) {
                error_log("Database connection error: " . $e->getMessage());
            }
            throw new Exception("Database connection failed");
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        if ($this->connection === null) {
            throw new Exception("Database connection not established");
        }

        return $this->connection;
    }

    public function close(): void
    {
        if ($this->connection !== null) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {}
} 
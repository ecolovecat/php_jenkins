<?php

class Config
{
    // Database Configuration
    public const DB_HOST = 'localhost';
    public const DB_USERNAME = 'root';
    public const DB_PASSWORD = '';
    public const DB_NAME = 'login_system';
    public const DB_CHARSET = 'utf8';

    // Security Configuration
    public const SESSION_LIFETIME = 3600; // 1 hour
    public const CSRF_TOKEN_NAME = 'csrf_token';
    
    // Password Configuration
    public const MIN_PASSWORD_LENGTH = 6;
    public const PASSWORD_REQUIRE_LETTERS = true;
    public const PASSWORD_REQUIRE_NUMBERS = true;
    
    // Username Configuration
    public const MIN_USERNAME_LENGTH = 3;
    public const MAX_USERNAME_LENGTH = 50;
    
    // Application Configuration
    public const APP_NAME = 'Login System';
    public const APP_VERSION = '1.0.0';
    public const TIMEZONE = 'UTC';
    
    // Development/Production flags
    public const ENVIRONMENT = 'development'; // 'development' or 'production'
    public const DEBUG_MODE = true;
    public const LOG_ERRORS = true;

    public static function init(): void
    {
        // Set timezone
        date_default_timezone_set(self::TIMEZONE);
        
        // Configure error reporting based on environment
        if (self::ENVIRONMENT === 'production') {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('log_errors', 1);
        }
    }

    public static function get(string $key, $default = null)
    {
        return defined("self::$key") ? constant("self::$key") : $default;
    }
} 
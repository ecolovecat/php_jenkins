<?php

require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../classes/Validator.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/Response.php';

class AuthController
{
    private User $userModel;
    private Validator $validator;

    public function __construct()
    {
        $this->userModel = new User();
        $this->validator = new Validator();
    }

    public function showSignup(): void
    {
        Session::start();
        $token = Session::generateToken();
        $errors = Session::get('errors', []);
        $old_input = Session::get('old_input', []);
        
        // Clear flash data
        Session::remove('errors');
        Session::remove('old_input');

        require_once __DIR__ . '/../views/signup.php';

        return;
    }

    public function showLogin(): void
    {
        Session::start();
        $token = Session::generateToken();
        $errors = Session::get('errors', []);
        $old_input = Session::get('old_input', []);
        
        // Clear flash data
        Session::remove('errors');
        Session::remove('old_input');

        require_once __DIR__ . '/../views/login.php';

        return;
    }

    public function handleSignup(): Response
    {
        Session::start();

        try {
            // Validate CSRF token
            $token = $_POST[Config::CSRF_TOKEN_NAME] ?? '';
            if (!Session::validateToken($token)) {
                Session::set('errors', ['general' => 'Invalid request. Please try again.']);
                header('Location: index.php?action=signup');
                exit;
            }

            // Get and sanitize input
            $username = $this->validator->sanitizeString($_POST['uid'] ?? '');
            $password = $_POST['pwd'] ?? '';
            $passwordRepeat = $_POST['pwdrepeat'] ?? '';
            $email = $this->validator->sanitizeEmail($_POST['email'] ?? '');

            // Store old input for repopulation (except passwords)
            Session::set('old_input', [
                'uid' => $username,
                'email' => $email
            ]);

            // Validate input
            $this->validateSignupInput($username, $password, $passwordRepeat, $email);

            if ($this->validator->hasErrors()) {
                Session::set('errors', $this->validator->getErrors());
                header('Location: index.php?action=signup');
                exit;
            }

            // Attempt registration
            $response = $this->userModel->register($username, $password, $email);

            if ($response->isSuccess()) {
                Session::remove('old_input');
                Session::set('success_message', $response->getMessage());
                header('Location: index.php?action=login');
                exit;
            }

            Session::set('errors', $response->getErrors());
            header('Location: index.php?action=signup');
            exit;

        } catch (Exception $e) {
            if (Config::LOG_ERRORS) {
                error_log("Signup error: " . $e->getMessage());
            }
            Session::set('errors', ['general' => 'An unexpected error occurred. Please try again.']);
            header('Location: index.php?action=signup');
            exit;
        }
    }

    public function handleLogin(): Response
    {
        Session::start();

        try {
            // Validate CSRF token
            $token = $_POST[Config::CSRF_TOKEN_NAME] ?? '';
            if (!Session::validateToken($token)) {
                Session::set('errors', ['general' => 'Invalid request. Please try again.']);
                header('Location: index.php?action=login');
                exit;
            }

            // Get and sanitize input
            $username = $this->validator->sanitizeString($_POST['uid'] ?? '');
            $password = $_POST['pwd'] ?? '';

            // Store old input for repopulation
            Session::set('old_input', ['uid' => $username]);

            // Validate input
            $this->validateLoginInput($username, $password);

            if ($this->validator->hasErrors()) {
                Session::set('errors', $this->validator->getErrors());
                header('Location: index.php?action=login');
                exit;
            }

            // Attempt authentication
            $response = $this->userModel->authenticate($username, $password);

            if ($response->isSuccess()) {
                $user = $response->getData()['user'];
                
                // Set session data
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::set('email', $user['email']);
                
                // Update last login
                $this->userModel->updateLastLogin($user['id']);
                
                // Clear old input and redirect
                Session::remove('old_input');
                header('Location: index.php?action=welcome');
                exit;
            }

            Session::set('errors', $response->getErrors());
            header('Location: index.php?action=login');
            exit;

        } catch (Exception $e) {
            if (Config::LOG_ERRORS) {
                error_log("Login error: " . $e->getMessage());
            }
            Session::set('errors', ['general' => 'An unexpected error occurred. Please try again.']);
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function showWelcome(): void
    {
        Session::requireLogin();
        require_once __DIR__ . '/../views/welcome.php';

        return;
    }

    public function handleLogout(): void
    {
        Session::destroy();
        header('Location: index.php?action=login');
        exit;
    }

    private function validateSignupInput(string $username, string $password, string $passwordRepeat, string $email): void
    {
        $this->validator->validateRequired('uid', $username, 'Username');
        $this->validator->validateRequired('pwd', $password, 'Password');
        $this->validator->validateRequired('pwdrepeat', $passwordRepeat, 'Password confirmation');
        $this->validator->validateRequired('email', $email, 'Email');

        if (!empty($username)) {
            $this->validator->validateUsername('uid', $username);
        }

        if (!empty($password)) {
            $this->validator->validatePassword('pwd', $password);
        }

        if (!empty($password) && !empty($passwordRepeat)) {
            $this->validator->validatePasswordMatch('pwdrepeat', $password, $passwordRepeat);
        }

        if (!empty($email)) {
            $this->validator->validateEmail('email', $email);
        }

        return;
    }

    private function validateLoginInput(string $username, string $password): void
    {
        $this->validator->validateRequired('uid', $username, 'Username');
        $this->validator->validateRequired('pwd', $password, 'Password');

        return;
    }
}

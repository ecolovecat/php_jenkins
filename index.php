<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <?php
        // Error reporting for development (remove in production)
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        try {
            require_once 'controllers/AuthController.php';

            $authController = new AuthController();
            $action = $_GET['action'] ?? '';

            switch ($action) {
                case 'signup':
                    $authController->showSignup();
                    break;
                case 'login':
                    $authController->showLogin();
                    break;
                case 'handleSignup':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $authController->handleSignup();
                    } else {
                        header('Location: index.php?action=signup');
                        exit;
                    }
                    break;
                case 'handleLogin':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $authController->handleLogin();
                    } else {
                        header('Location: index.php?action=login');
                        exit;
                    }
                    break;
                case 'welcome':
                    $authController->showWelcome();
                    break;
                case 'logout':
                    $authController->handleLogout();
                    break;
                default:
                    $authController->showLogin();
                    break;
            }

        } catch (Exception $e) {
            error_log("Application error: " . $e->getMessage());
            echo '<div class="error-container"><div class="error">An unexpected error occurred. Please try again later.</div></div>';
        }
        ?>
    </div>
</body>

</html>
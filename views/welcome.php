<!-- create a welcome page that displays the username of the user and header, footer, header with lougout button, and footer  -->

<?php
require_once __DIR__ . '/../logger/LoggerFactory.php';


// Authentication is already handled by Session::requireLogin() in controller
$username = Session::get('username');
$email = Session::get('email');

$log = LoggerFactory::create('console')->log('Welcome ' . $username) ?? 'No log';

?>

<div class="welcome-container">
    <!-- Header with logout button -->
    <header class="welcome-header">
        <h1>Welcome Portal</h1>
        <a href="?action=logout" class="logout-btn">Logout</a>
    </header>

    <!-- Main content area -->
    <main class="welcome-content">
        <h2>Hello!</h2>
        <div class="username-display">
            <?php 
            echo htmlspecialchars($username); 
            echo $log;
            ?>
        </div>
        <div class="welcome-message">
            <p>Welcome to your dashboard! You have successfully logged into the system.</p>
            <p>Your session is secure and you can now access all available features.</p>
            <?php if ($email): ?>
                <p>Email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="welcome-footer">
        <p>&copy; 2024 Login System. All rights reserved.</p>
    </footer>
</div>


  




<?php
// login.php
session_start();
require 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/php/logs/php_error_log');

// On failure we echo the message directly (no redirect), so the
// fetch()-based login form on login.html can show it inline.
// We only redirect on a SUCCESSFUL login.
function fail($message, $logMessage = null) {
    error_log($logMessage ?? $message);
    echo $message;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        fail('Username and password are required.', 'Login failed: Empty username or password');
    }

    try {
        $tableCheck = $pdo->query("SHOW TABLES LIKE 'Admins'");
        if ($tableCheck->rowCount() > 0) {
            $stmt = $pdo->prepare("SELECT AdminID, Password FROM Admins WHERE Username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['Password'])) {
                $_SESSION['admin_id'] = $admin['AdminID'];
                header('Location: admin.html');
                error_log('Admin login successful: ' . $username);
                exit();
            }
        }

        $tableCheck = $pdo->query("SHOW TABLES LIKE 'Users'");
        if ($tableCheck->rowCount() === 0) {
            fail('Users table not found.', 'Login failed: Users table not found');
        }

        $stmt = $pdo->prepare("SELECT UserID, Password FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            header('Location: dashboard.html');
            error_log('User login successful: ' . $username);
            exit();
        } else {
            fail('Invalid username or password.', 'Login failed: Invalid credentials for ' . $username);
        }
    } catch (PDOException $e) {
        error_log('Login PDO error: ' . $e->getMessage());
        fail('Database error.');
    }
} else {
    fail('Please use the login form.', 'Direct access to login.php');
}
?>

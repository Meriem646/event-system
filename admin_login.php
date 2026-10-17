<?php
// admin_login.php
require 'db_connection.php';
session_start();

// Configure error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/php/logs/php_error_log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = 'Username and password are required.';
        header('Location: login.html');
        exit();
    }

    try {
        // Check if Admins table exists
        $tableCheck = $pdo->query("SHOW TABLES LIKE 'Admins'");
        if ($tableCheck->rowCount() === 0) {
            $_SESSION['login_error'] = 'Admins table not found. Please set up the database.';
            header('Location: login.html');
            exit();
        }

        // Fetch admin data
        $stmt = $pdo->prepare("SELECT AdminID, Password FROM Admins WHERE Username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['Password'])) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            unset($_SESSION['login_error']); // Clear any previous error
            header('Location: admin.html');
            exit();
        } else {
            $_SESSION['login_error'] = 'Invalid admin credentials.';
            header('Location: login.html');
            exit();
        }
    } catch (PDOException $e) {
        error_log('Admin Login PDO error: ' . $e->getMessage());
        $_SESSION['login_error'] = 'Database error occurred. Please try again later.';
        header('Location: login.html');
        exit();
    } catch (Exception $e) {
        error_log('Admin Login general error: ' . $e->getMessage());
        $_SESSION['login_error'] = 'An unexpected error occurred.';
        header('Location: login.html');
        exit();
    }
} else {
    $_SESSION['login_error'] = 'Invalid request method.';
    header('Location: login.html');
    exit();
}
?>
<?php
// register.php
session_start();
require 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/php/logs/php_error_log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($email) || empty($phone) || empty($password)) {
        echo 'All fields are required.';
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Username = ? OR Email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            echo 'Username or email already exists.';
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO Users (Username, Email, Phone, Password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $phone, $hashedPassword]);

        echo 'Registration successful! Redirecting to login...';
        header('Refresh: 2; URL=login.html');
        exit();
    } catch (PDOException $e) {
        error_log('Registration PDO error: ' . $e->getMessage());
        echo 'Database error: ' . $e->getMessage();
        exit();
    } catch (Exception $e) {
        error_log('Registration general error: ' . $e->getMessage());
        echo 'An error occurred.';
        exit();
    }
} else {
    echo 'Invalid request method.';
    exit();
}
?>

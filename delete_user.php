<?php
// delete_user.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to delete users.";
    exit();
}

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo "User ID is required.";
    exit();
}

// Delete the user
$stmt = $pdo->prepare("DELETE FROM Users WHERE UserID = ?");
$stmt->execute([$user_id]);

echo "User deleted successfully.";
?>

<?php
// manage_users.php

require 'db_connection.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'You must be logged in as an admin to manage users.']);
    exit();
}

// Fetch all users
$stmt = $pdo->prepare("SELECT UserID, Username, Email, Phone FROM Users");
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>

<?php
// view_registrations.php

require 'db_connection.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'You must be logged in as an admin to view registrations.']);
    exit();
}

// Fetch all registrations
$stmt = $pdo->prepare("
    SELECT r.RegistrationID, u.Username, u.Email, e.EventName, e.Date, e.Location
    FROM Registrations r
    JOIN Users u ON r.UserID = u.UserID
    JOIN Events e ON r.EventID = e.EventID
");
$stmt->execute();

$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($registrations);
?>

<?php
// register_event.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to register for an event.";
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'] ?? null;

if (!$event_id) {
    echo "Event ID is required.";
    exit();
}

// Check for existing registration
$stmt = $pdo->prepare("SELECT * FROM Registrations WHERE EventID = ? AND UserID = ?");
$stmt->execute([$event_id, $user_id]);

if ($stmt->rowCount() > 0) {
    echo "You are already registered for this event.";
    exit();
}

// Register user for the event
$stmt = $pdo->prepare("INSERT INTO Registrations (EventID, UserID) VALUES (?, ?)");
$stmt->execute([$event_id, $user_id]);

echo "Successfully registered for the event.";
?>

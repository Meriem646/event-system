<?php
// edit_event.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to edit events.";
    exit();
}

$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    echo "Event ID is required.";
    exit();
}

// Fetch the current event details
$stmt = $pdo->prepare("SELECT * FROM Events WHERE EventID = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Event not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'] ?? '';
    $date = $_POST['date'] ?? '';
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($event_name) || empty($date) || empty($location) || empty($description)) {
        echo "All fields are required.";
        exit();
    }

    $stmt = $pdo->prepare("UPDATE Events SET EventName = ?, Date = ?, Location = ?, Description = ? WHERE EventID = ?");
    $stmt->execute([$event_name, $date, $location, $description, $event_id]);

    echo "Event updated successfully.";
}
?>

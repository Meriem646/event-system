<?php
// delete_event.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to delete events.";
    exit();
}

$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    echo "Event ID is required.";
    exit();
}

// Delete the event
$stmt = $pdo->prepare("DELETE FROM Events WHERE EventID = ?");
$stmt->execute([$event_id]);

echo "Event deleted successfully.";
?>

<?php
// add_event.php

require 'db_connection.php';
session_start();


if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to add events.";
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

    $stmt = $pdo->prepare("INSERT INTO Events (EventName, Date, Location, Description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$event_name, $date, $location, $description]);

    echo "Event added successfully.";
}
?>

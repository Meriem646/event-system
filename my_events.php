<?php
// my_events.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your registered events.";
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT Events.EventName, Events.Date, Events.Location, Events.Description
    FROM Events
    JOIN Registrations ON Events.EventID = Registrations.EventID
    WHERE Registrations.UserID = ?
    ORDER BY Events.Date ASC
");

$stmt->execute([$user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($events)) {
    echo "You haven't registered for any events yet.";
} else {
    foreach ($events as $event) {
        echo "Event Name: " . $event['EventName'] . "<br>";
        echo "Date: " . $event['Date'] . "<br>";
        echo "Location: " . $event['Location'] . "<br>";
        echo "Description: " . $event['Description'] . "<br><br>";
    }
}
?>

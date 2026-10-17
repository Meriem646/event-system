<?php
// add_location.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to add locations.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_name = $_POST['location_name'] ?? '';
    $address = $_POST['address'] ?? '';

    if (empty($location_name) || empty($address)) {
        echo "Both location name and address are required.";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO Locations (LocationName, Address) VALUES (?, ?)");
    $stmt->execute([$location_name, $address]);

    echo "Location added successfully.";
}
?>

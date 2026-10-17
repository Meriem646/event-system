<?php
// import_events.php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to import events.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $csv = $input['csv'] ?? '';

    if (empty($csv)) {
        echo "No data provided.";
        exit();
    }

    $lines = explode("\n", $csv);
    array_shift($lines); // Skip header
    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if (count($data) >= 4) {
            $event_name = $data[0];
            $date = $data[1];
            $location = $data[2];
            $description = $data[3];
            $stmt = $pdo->prepare("INSERT INTO Events (EventName, Date, Location, Description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$event_name, $date, $location, $description]);
        }
    }

    echo "Events imported successfully.";
}
?>


<?php
// events.php

require 'db_connection.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM Events ORDER BY Date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);
?>

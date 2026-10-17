<?php
// add_category.php

require 'db_connection.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to add categories.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'] ?? '';

    if (empty($category_name)) {
        echo "Category name is required.";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO Categories (CategoryName) VALUES (?)");
    $stmt->execute([$category_name]);

    echo "Category added successfully.";
}
?>

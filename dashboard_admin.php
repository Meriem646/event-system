<?php
// dashboard_admin.php

require 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "You must be logged in as an admin to access the dashboard.";
    exit();
}

// Display admin options
echo "Welcome to the Admin Dashboard!<br>";
echo "<a href='add_event.php'>Add Event</a><br>";
echo "<a href='edit_event.php'>Edit Event</a><br>";
echo "<a href='delete_event.php'>Delete Event</a><br>";
echo "<a href='view_registrations.php'>View Registrations</a><br>";
echo "<a href='manage_users.php'>Manage Users</a><br>";
echo "<a href='add_category.php'>Add Category</a><br>";
echo "<a href='add_location.php'>Add Location</a><br>";
echo "<a href='logout.php'>Logout</a><br>";
?>

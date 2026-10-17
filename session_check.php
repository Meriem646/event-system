<?php
// session_check.php
session_start();

function check_user_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.html");
        exit();
    }
}

function check_admin_login() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.html");
        exit();
    }
}
?>


<?php
// check_session.php
session_start();
header('Content-Type: application/json');

$response = [
    'loggedIn' => false,
    'isAdmin' => false
];

if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    $response['loggedIn'] = true;
    $response['isAdmin'] = isset($_SESSION['admin_id']);
}

echo json_encode($response);
exit();
?>

<?php
session_start();
echo json_encode([
    'loggedin' => isset($_SESSION['user_id']),
    'username' => isset($_SESSION['username']) ? $_SESSION['username'] : ''
]);
?>

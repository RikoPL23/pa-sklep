<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderData = json_decode($_POST['orderData'], true);
    $userId = $_SESSION['user_id'];

    // Process the order (this is just an example, actual order processing might include more steps)
    $totalPrice = array_reduce($orderData, function($sum, $item) {
        return $sum + $item['price'];
    }, 0);

    echo "Order placed successfully. Total price: " . $totalPrice . " zł";
}
?>

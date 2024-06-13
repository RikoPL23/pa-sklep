<?php
include 'config.php';
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'moderator' && $_SESSION['role'] != 'admin')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $sale = isset($_POST['sale']) ? 1 : 0;
    $saleAmount = $_POST['saleAmount'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, category, price, image, sale, saleAmount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdds", $name, $description, $category, $price, $image, $sale, $saleAmount);

    if ($stmt->execute()) {
        header("Location: admin_panel.php?message=product_added");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

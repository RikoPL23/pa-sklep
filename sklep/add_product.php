<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    die("Dostęp zabroniony");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO products (name, description, price, stock) VALUES ('$name', '$description', '$price', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt dodany pomyślnie!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodawanie produktu</title>
</head>
<body>
    <form method="POST" action="">
        Nazwa: <input type="text" name="name" required><br>
        Opis: <textarea name="description" required></textarea><br>
        Cena: <input type="number" step="0.01" name="price" required><br>
        Ilość: <input type="number" name="stock" required><br>
        <input type="submit" value="Dodaj produkt">
    </form>
</body>
</html>

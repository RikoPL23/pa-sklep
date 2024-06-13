<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'moderator')) {
    die("Dostęp zabroniony");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM products WHERE id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt usunięty pomyślnie!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Zarządzanie produktami</title>
</head>
<body>
    <h2>Produkty</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM products");
        while($row = $result->fetch_assoc()) {
            echo "<li>ID: {$row['id']}, Nazwa: {$row['name']}, Cena: {$row['price']}</li>";
        }
        ?>
    </ul>
    <form method="POST" action="">
        ID produktu do usunięcia: <input type="number" name="product_id" required><br>
        <input type="submit" value="Usuń produkt">
    </form>
</body>
</html>

<?php
include 'config.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Access denied');
}

$message = '';
if (isset($_GET['message']) && $_GET['message'] == 'product_added') {
    $message = 'Produkt został dodany pomyślnie.';
}

// Fetch users and products for display
$users = [];
$products = [];

$userResult = $conn->query("SELECT id, username, role FROM users");
while ($userRow = $userResult->fetch_assoc()) {
    $users[] = $userRow;
}

$productResult = $conn->query("SELECT id, name, price FROM products");
while ($productRow = $productResult->fetch_assoc()) {
    $products[] = $productRow;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Panel Administracyjny | Gymownia</title>
</head>
<body>
    <header>
        <h1 class="header-title">
            <span>Gymownia</span> Panel Administracyjny
        </h1>
        <div class="auth-user">
            <span><?php echo $_SESSION['username']; ?></span>
            <button class="auth-btn" onclick="logout()">Wyloguj</button>
        </div>
    </header>
    <main class="container">
        <section class="admin-section">
            <h2>Zarządzanie Użytkownikami</h2>
            <?php if ($message): ?>
                <p class="success-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form class="form" action="manage_users.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="text" name="username" placeholder="Nazwa użytkownika" class="form-input" required>
                <input type="password" name="password" placeholder="Hasło" class="form-input" required>
                <select name="role" class="form-input">
                    <option value="user">User</option>
                    <option value="moderator">Moderator</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="form-button">Dodaj użytkownika</button>
            </form>
            <h2>Lista użytkowników</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa użytkownika</th>
                        <th>Rola</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <form action="manage_users.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="admin-section">
            <h2>Zarządzanie Produktami</h2>
            <form class="form" action="add_product.php" method="post">
                <input type="text" name="name" placeholder="Nazwa produktu" class="form-input" required>
                <textarea name="description" placeholder="Opis produktu" class="form-input" required></textarea>
                <input type="text" name="category" placeholder="Kategoria" class="form-input" required>
                <input type="number" step="0.01" name="price" placeholder="Cena" class="form-input" required>
                <input type="text" name="image" placeholder="Ścieżka do obrazka" class="form-input" required>
                <label>
                    <input type="checkbox" name="sale"> Promocja
                </label>
                <input type="number" step="0.01" name="saleAmount" placeholder="Kwota promocji" class="form-input">
                <button type="submit" class="form-button">Dodaj produkt</button>
            </form>
            <h2>Lista produktów</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa produktu</th>
                        <th>Cena</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td>
                            <form action="delete_product.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
        function logout() {
            fetch('logout.php').then(response => {
                if (response.ok) {
                    window.location.href = 'index.html';
                }
            });
        }
    </script>
</body>
</html>

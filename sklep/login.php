<?php
include 'config.php';
session_start();

$message = '';

if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = 'Rejestracja udana. Możesz się teraz zalogować.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Logowanie | Gymownia</title>
</head>
<body>
    <header>
        <h1 class="header-title">
            <span>Gymownia</span> Logowanie
        </h1>
    </header>
    <main class="container">
        <section class="auth-form">
            <?php if ($message): ?>
                <p class="success-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form class="form" action="login.php" method="post">
                <input type="text" name="username" placeholder="Nazwa użytkownika" class="form-input" required>
                <input type="password" name="password" placeholder="Hasło" class="form-input" required>
                <button type="submit" class="form-button">Zaloguj się</button>
            </form>
        </section>
    </main>
</body>
</html>

<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($user['role'] == 'moderator') {
            header("Location: moderator_dashboard.php");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
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
    <div class="auth-buttons">
         
            <button class="auth-btn" onclick="window.location.href='index.html'">Strona Główna</button>
        </div>
    <main class="container">
        <section class="auth-form">
            <form class="form" method="post" action="login.php">
                <input type="text" name="username" placeholder="Nazwa użytkownika" class="form-input" required>
                <input type="password" name="password" placeholder="Hasło" class="form-input" required>
                <button type="submit" class="form-button">Zaloguj</button>
            </form>
        </section>
    </main>
</body>
</html>

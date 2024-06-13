<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'client')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rejestracja | Gymownia</title>
</head>
<body>
    <header>
        <h1 class="header-title">
            <span>Gymownia</span> Rejestracja
        </h1>
        <div class="auth-buttons">
          
            <button class="auth-btn" onclick="window.location.href='index.html'">Strona Główna</button>
        </div>
    </header>
    <main class="container">
        <section class="auth-form">
            <form class="form" method="post" action="register.php">
                <input type="text" name="username" placeholder="Nazwa użytkownika" class="form-input" required>
                <input type="password" name="password" placeholder="Hasło" class="form-input" required>
                <input type="password" name="confirm_password" placeholder="Potwierdź hasło" class="form-input" required>
                <button type="submit" class="form-button">Zarejestruj</button>
            </form>
        </section>
    </main>
</body>
</html>


<?php
$servername = "localhost";
$username = "root"; // domyślny użytkownik
$password = ""; // domyślnie puste
$dbname = "users_db";

// Utworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

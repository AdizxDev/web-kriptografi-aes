<?php
session_start();
include 'includes/db.php';

$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);

$query = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $_SESSION['user'] = $result->fetch_assoc();
    header("Location: dashboard.php");
} else {
    $_SESSION['error'] = "Username atau Password salah!";
    header("Location: index.php");
}
?>

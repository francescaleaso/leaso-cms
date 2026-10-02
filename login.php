<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="robots" content="noindex, nofollow">
</head>

<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);

$sql = "SELECT * FROM admin WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    exit;
} else {
    echo "Login fallito. <a href='formAccessLeaso78.php'>Riprova</a>";
}
?>

<?php
$host = "YOUR_DATABASE_HOST";
$dbname = "YOUR_DATABASE_NAME";
$user = "YOUR_DATABASE_USER";
$pass = "YOUR_DATABASE_PASSWORD";

$conn = @new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Errore connessione: " . $conn->connect_error);
}
?>

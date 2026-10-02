<?php
session_start();

include 'config.php';

// 🔒 Controllo se l'utente è loggato
if (!isset($_SESSION['admin'])) {
    header("Location: formAccessLeaso78.php");
    exit;
}

// ⏳ Timeout della sessione (10 minuti)
$durata_sessione = 600;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $durata_sessione) {
    session_unset();
    session_destroy();
    header("Location: formAccessLeaso78.php");
    exit;
}
$_SESSION['last_activity'] = time();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM immagini WHERE id = $id";
    $conn->query($sql);
}

$conn->close();
header("Location: modifica.php");
exit;
?>

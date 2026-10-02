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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $titolo = $_POST['titolo'];
    $categoria = $_POST['categoria'];

    // Se è stata caricata una nuova immagine
    if (!empty($_FILES['immagine']['name'])) {
        $target = "uploads/" . basename($_FILES["immagine"]["name"]);
        move_uploaded_file($_FILES["immagine"]["tmp_name"], $target);

        $sql = "UPDATE immagini SET titolo=?, categoria=?, immagine=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titolo, $categoria, $target, $id);
    } else {
        $sql = "UPDATE immagini SET titolo=?, categoria=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $titolo, $categoria, $id);
    }

    $stmt->execute();
}

$conn->close();
header("Location: modifica.php");
exit;
?>

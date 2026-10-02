<?php
session_start();
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin'])) {
    header("Location: formAccessLeaso78.php");
    exit;
}

$titolo = $_POST['titolo'];
$categoria = $_POST['categoria'];
$immagine = $_FILES['immagine'];

$upload_dir = "uploads/";

// Controllo e creazione cartella uploads se non esiste
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Pulizia nome file
$nome_file_pulito = preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($immagine["name"]));
$target_file = $upload_dir . $nome_file_pulito;

if (move_uploaded_file($immagine["tmp_name"], $target_file)) {
    $sql = "INSERT INTO immagini (titolo, nome_file, categoria) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $titolo, $nome_file_pulito, $categoria);
    $stmt->execute();
    echo "Caricamento riuscito. <a href='dashboard.php'>Torna alla dashboard</a>";
} else {
        var_dump($immagine);
    echo "Errore nel caricamento...";
    echo "Errore nel caricamento del file.<br>";
    echo "Codice errore: " . $immagine["error"];
    echo "<br>Cartella uploads reale: " . realpath($upload_dir);
}
?>

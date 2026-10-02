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

// Query immagini
$sql = "SELECT id, titolo, nome_file, categoria FROM immagini";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Modifica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font & Icone -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/modifica.css?v=3">
</head>
<body>
    <div class="dashboard-container">
        <!-- COLONNA SINISTRA -->
        <aside class="left-column">
            <div class="menu-container">
                <div class="menu selected">
                    <i class="bi bi-images"></i>
                    <p><a href="modifica.php">Galleria</a></p>
                </div>
                <div class="menu">
                    <i class="bi bi-plus-square"></i>
                    <p><a href="dashboard.php">Aggiungi</a></p>
                </div>
                <div class="menu">
                    <i class="bi bi-gear"></i>
                    <p><a href="#">Impostazioni</a></p>
                </div>
            </div>

            <div class="logout-menu">
                <div class="menu">
                    <i class="bi bi-box-arrow-right"></i>
                    <p><a href="logout.php">Log Out</a></p>
                </div>
            </div>
        </aside>

        <!-- COLONNA DESTRA -->
        <div class="gallery">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<img src='uploads/" . htmlspecialchars($row['nome_file']) . "' alt='" . htmlspecialchars($row['titolo']) . "'>";
                        echo "<h3 class='truncate' title=' ".$row['titolo']." '>" . htmlspecialchars($row['titolo']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['categoria']) . "</p>";

                        // Bottoni
                        echo "<div class='card-actions'>";
                        echo "<form action='delete.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-delete'>>Elimina <i class='bi bi-trash3'></i></button>
                            </form>";

                        echo "<form action='edit.php' method='GET' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-edit'>Modifica <i class='bi bi-pencil-fill'></i></button>
                            </form>";
                        echo "</div>";

                        echo "</div>";
                    }
                } else {
                    echo "Nessuna immagine trovata.";
                }
                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>

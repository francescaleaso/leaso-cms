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
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Carica Foto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font & Icone -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        
        <!-- COLONNA SINISTRA -->
        <aside class="left-column">
            <div class="card-container">
                <div class="card">
                    <i class="bi bi-images"></i>
                    <p><a href="modifica.php">Galleria</a></p>
                </div>
                <div class="card selected">
                    <i class="bi bi-plus-square-fill"></i>
                    <p><a href="dashboard.php">Aggiungi</a></p>
                </div>
                <div class="card">
                    <i class="bi bi-gear"></i>
                    <p><a href="#">Impostazioni</a></p>
                </div>
            </div>

            <div class="logout-card">
                <div class="card">
                    <i class="bi bi-box-arrow-right"></i>
                    <p><a href="logout.php">Log Out</a></p>
                </div>
            </div>
        </aside>

        <!-- COLONNA CENTRALE -->
        <main class="center-column">
            <div class="center-top">
                <i class="bi bi-cloud-upload"></i>
                <h2>Carica Foto</h2>
            </div>

            <form action="upload.php" method="POST" enctype="multipart/form-data">
                
                <!-- Selezione immagine -->
                <div class="left">
                    <div class="upload-box" id="uploadBox" style="width: 270px;">
                        <span>Clicca per selezionare un'immagine</span>
                        <img id="previewImage" alt="Anteprima immagine">
                    </div>
                    <input type="file" name="immagine" id="fileInput" accept="image/*" hidden required>
                </div>

                <!-- Dettagli immagine -->
                <div class="right" style="margin-right: 70px;">
                    <label for="categoria" style="margin-bottom: 20px; font-weight: 500;">Categoria</label>
                    <select name="categoria" id="categoria" required>
                        <option value="" disabled selected hidden>Seleziona</option>
                        <option value="awards">Premiazioni</option>
                        <option value="puppies">Cuccioli</option>
                    </select>

                    <label for="titolo" style="margin: 20px 0; font-weight: 500;">Titolo</label>
                    <input type="text" id="titolo" name="titolo" placeholder="Es. Enci Show 2025..." required style="margin-bottom: 80px;">

                    <div class="buttons">
                        <button type="submit">Carica <i class="bi bi-plus-square"></i></button>
                        <button type="reset">Annulla</button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- SCRIPT -->
    <script>
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        const uploadBox = document.getElementById('uploadBox');

        uploadBox.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImage.src = e.target.result;
                    uploadBox.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = "";
                uploadBox.classList.remove('has-image');
            }
        });
    </script>
</body>
</html>
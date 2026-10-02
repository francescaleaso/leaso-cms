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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM immagini WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica</title>
    <!-- Font & Icone -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Poppins', sans-serif;
        }

        body {
          background-color: #f1f5f9;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        .container {
          background: #fff;
          padding: 40px 30px;
          border-radius: 16px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.1);
          width: 100%;
          max-width: 450px;
          text-align: left;
        }

        h2 {
          color: #0f766e;
          font-size: 24px;
        }

        label {
          display: block;
          font-weight: 500;
          margin: 20px 0 10px;
          color: #333;
        }

        /* Input text identico a dashboard */
        input[type="text"] {
          font-size: 0.9rem;
          font-family: 'Poppins';
          background-color: #f0f0f0;
          border: 1px solid #ccc;
          border-radius: 8px;
          padding: 10px;
          width: 100%;
        }

        select {
            font-size: 0.9rem;
            font-family: 'Poppins';
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
        }

        /* File input (visibile ma nello stesso stile) */
        input[type="file"] {
          font-size: 0.9rem;
          font-family: 'Poppins';
          background-color: #f0f0f0;
          border: 1px solid #ccc;
          border-radius: 8px;
          padding: 10px;
          width: 100%;
        }

        /* Bottone identico */
        button[type="submit"] {
          font-family: 'Poppins';
          padding: 10px 20px;
          color: #008080b8;
          background-color: #f0f0f0;
          font-size: 16px;
          border: 2px solid #008080b8;
          border-radius: 8px;
          cursor: pointer;
          transition: background-color 0.3s;
          margin-top: 20px;
          width: 100%;
        }

        button[type="submit"]:hover {
          background-color: #008080b8;
          color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="top" style="display: flex; flex-direction: row; gap: 55px; align-items: center;">
        <i class="bi bi-arrow-left" onclick="window.location.href = 'modifica.php';"></i>
        <h2>Modifica immagine</h2>
    </div>

    <form action="aggiorna.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Titolo:</label>
        <input type="text" name="titolo" value="<?php echo htmlspecialchars($row['titolo']); ?>">

        <label for="categoria">Categoria</label>
        <select id="categoria" name="categoria" required>
            <option value="awards" <?php echo ($row['categoria'] === 'awards') ? 'selected' : ''; ?>>Premiazioni</option>
            <option value="puppies" <?php echo ($row['categoria'] === 'puppies') ? 'selected' : ''; ?>>Cuccioli</option>
        </select>

        <label>Immagine:</label>
        <input type="file" name="immagine"><br><br>

        <button type="submit">Salva modifiche</button>
    </form>
</div>

</body>
</html>

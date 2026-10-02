<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

// Verifica connessione
if (!$conn) {
    die("Connessione non inizializzata.");
}

$sql = "SELECT * FROM immagini ORDER BY data_caricamento ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Errore query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="assets/css/galleria.css?v=2">
  <link rel="stylesheet" href="assets/css/index.css?v=2">
  <link rel="stylesheet" href="assets/css/main.css?v=2">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <title>Leaso's Selection - Galleria</title>
</head>
<body>

<!-- Navbar + Mobile Menu -->
<div class="navbar">
  <div class="topName">
    <img src="assets/img/logo.png" alt="logo"/>
    <span>Leaso's Selection</span>
  </div>
  <span class="menu-icon" onclick="openMenu()">☰</span>
  <div class="nav-links">
    <a href="index.html">Home</a>
    <div class="dropdown">
      <a href="galleria.php?filter=all" class="dropbtn">Galleria ▾</a>
      <div class="dropdown-content">
        <a href="galleria.php?filter=awards">Campioni</a>
        <a href="galleria.php?filter=puppies">Cuccioli</a>
      </div>
    </div>
    <a href="contatti.html">Contatti</a>
  </div>
</div>

<div id="menuPanel" class="menu-panel">
  <span class="close-btn" onclick="closeMenu()">×</span>
  <a href="index.html">Home</a>
  <a href="javascript:void(0);" onclick="toggleDropdown()">Galleria ▾</a>
  <div id="dropdownMobile" class="dropdown-mobile">
    <a href="galleria.php?filter=awards">Campioni</a>
    <a href="galleria.php?filter=puppies">Cuccioli</a>
  </div>
  <a href="contatti.html">Contatti</a>
</div>

<!-- Hero -->
<section class="hero">
  <h1 style="margin: 0;">👑</h1>
  <h1>I Nostri <span class="highlight">Bassotti</span></h1>
  <p style="max-width: 600px; margin: 1rem auto; color: #6b7280;">
    Cresciamo bassotti con passione, dedizione e rispetto per la loro natura. Ogni cucciolo è allevato in un ambiente familiare, pronto a diventare parte della tua.
  </p>
  <div class="filter-buttons">
    <button onclick="filterPhotos('all', this)" class="active-filter"><i class="bi bi-sliders"></i> Tutti</button>
    <button onclick="filterPhotos('awards', this)"><i class="bi bi-trophy"></i> Premiazioni</button>
    <button onclick="filterPhotos('puppies', this)" style="margin-right: 0;"><i class="bi bi-award"></i> Cuccioli</button>
  </div>
</section>

<!-- Galleria dinamica -->
<div class="container" id="gallery">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="photo <?php echo htmlspecialchars($row['categoria']); ?>" onclick="openLightbox(this)">
      <img src="uploads/<?php echo htmlspecialchars($row['nome_file']); ?>" alt="<?php echo htmlspecialchars($row['titolo']); ?>">
      <p><?php echo htmlspecialchars($row['titolo']); ?></p>
    </div>
  <?php endwhile; ?>
</div>

<!-- Lightbox -->
<div class="lightbox" onclick="closeLightbox()">
  <img id="lightbox-img" src="" alt="zoom" />
</div>

<!-- JS: interazioni -->
<script>
  function openMenu() {
    document.getElementById("menuPanel").classList.add("open");
  }

  function closeMenu() {
    document.getElementById("menuPanel").classList.remove("open");
  }

  function toggleDropdown() {
    document.getElementById("dropdownMobile").classList.toggle("open");
  }

  function openLightbox(el) {
    const imgSrc = el.querySelector('img').src;
    document.getElementById('lightbox-img').src = imgSrc;
    document.querySelector('.lightbox').style.display = 'flex';
  }

  function closeLightbox() {
    document.querySelector('.lightbox').style.display = 'none';
    document.getElementById('lightbox-img').src = '';
  }

  function filterPhotos(filter, button = null) {
    const allPhotos = document.querySelectorAll('.photo');
    const buttons = document.querySelectorAll('.filter-buttons button');
    buttons.forEach(btn => btn.classList.remove('active-filter'));
    if (button) button.classList.add('active-filter');

    allPhotos.forEach(photo => {
      if (filter === 'all' || photo.classList.contains(filter)) {
        photo.style.display = 'block';
      } else {
        photo.style.display = 'none';
      }
    });
  }

  function getFilterFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get('filter') || 'all';
  }

  window.onload = function () {
    const initialFilter = getFilterFromURL();
    const buttons = document.querySelectorAll('.filter-buttons button');

    buttons.forEach(button => {
      const filterName = button.textContent.trim().toLowerCase();
      if (initialFilter === 'all' && filterName.includes('tutti')) {
        button.classList.add('active-filter');
      } else if (initialFilter === 'awards' && filterName.includes('premiazioni')) {
        button.classList.add('active-filter');
      } else if (initialFilter === 'puppies' && filterName.includes('cuccioli')) {
        button.classList.add('active-filter');
      }
    });

    filterPhotos(initialFilter);
  };
</script>

</body>
</html>

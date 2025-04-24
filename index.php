<?php
// index.php (pagina principale)
include 'config.php';
session_start();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione Appuntamento - Clinica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="medici.php">I Nostri Medici</a></li>
                <li><a href="services.php">Servizi</a></li>
                <li><a href="contact.php">Contatti</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="auth-container">
                    <span class="auth-toggle">Ciao, <?php echo htmlspecialchars($_SESSION['user_name']); ?> ▼</span>
                    <div class="auth-dropdown">
                        <a href="areapersonale.php">Area Personale</a>
                        <a href="?logout=1">Esci</a>
                    </div>
                </li>
                <?php else: ?>
                <li class="auth-container">
                    <span class="auth-toggle">Accedi/Registrati ▼</span>
                    <div class="auth-dropdown">
                        <a href="login.php">Accedi</a>
                        <a href="register.php">Registrati</a>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="banner">
        <h1>Visite specialistiche e diagnostica</h1>
        <p>Un team di esperti medici è a tua disposizione.</p>
        <br>
        <form method="POST" action="login.php">
            <div class="form-group" >
            <button type="submit" >Prenota il tuo Appuntamento Online</button>
            </div>
        </form>

    </div>



<!-- Carousel 
    <div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">  
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="Images/img2.png" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="Images/img3.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="Images/img4.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="Images/img5.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="Images/img6.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="Images/img7.png" class="d-block w-100" alt="Slide 2">
        </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        </button>
    </div>
  </div>
</div>
-->

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Perché scegliere la nostra clinica</h2>
            <p >
                Offriamo servizi medici all'avanguardia con un team di specialisti qualificati,
                tempi di attesa ridotti e un ambiente accogliente per ogni esigenza sanitaria.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="Images/img7.png" alt="Immagine della clinica" class="img-fluid rounded shadow img-clinica">
        </div>
    </div>
    <br><br><br><br><br>
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Centri Medici PAS</h2>
            <ul>
                <li>Tariffe sociali
                <li>Zero tempi di attesa
                <li>Facilità di prenotazione
            </ul>
            <p class="paragrafo-piccolo">
            La Rete PAS “Pubbliche Assistenze Sanità - Centri Medici del No Profit” è il primo sistema di Assistenza Ambulatoriale Diagnostica nato in Toscana
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="Images/img6.png" alt="Immagine della clinica" class="img-fluid rounded shadow img-clinica">
        </div>
    </div>
</div>

<div class="banner2">
    <h3>Prenota adesso:</h2>
    <form method="POST" action="login.php">
        <div class="form-group" >
            <button type="submit" >Prenotazioni Online</button>
        </div>
    </form>
</div>
<footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
</footer>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    
</body>
</html>
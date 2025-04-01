<?php
// Connessione al database
include 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I Nostri Medici - Clinica</title>
    <link rel="stylesheet" href="./style.css"> <!-- Assicurati di includere il percorso corretto -->
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Clinica Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="medici.php">I Nostri Medici</a></li>
                <li><a href="services.php">Servizi</a></li>
                <li><a href="contact.php">Contatti</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>I Nostri Medici</h2>
        <ul>
            <?php foreach ($medici as $medico): ?>
                <li>
                    <h3><?= $medico['nome']; ?></h3>
                    <p>Specializzazione: <?= $medico['specializzazione']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>

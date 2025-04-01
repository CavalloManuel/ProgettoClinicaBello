<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione Appuntamento - Clinica</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home  </a></li>
                <li><a href="medici.php">I Nostri Medici  </a></li>
                <li><a href="services.php">Servizi  </a></li>
                <li><a href="contact.php">Contatti  </a></li>
            </ul>
        </nav>
    </header>

    <div class="banner">
        <h1>Benvenuto alla Clinica! Prenota il tuo Appuntamento Oggi</h1>
        <p>Un team di esperti medici è a tua disposizione.</p>
    </div>

    <div class="container">
        <h2>Prenota un Appuntamento</h2>
        <form method="POST" action="index.php">
            <label for="user_id">ID Utente:</label>
            <input type="number" id="user_id" name="user_id" required>

            <label for="medico_id">Scegli il Medico:</label>
            <select id="medico_id" name="medico_id" required>
                <?php foreach ($medici as $medico): ?>
                    <option value="<?= $medico['id']; ?>"><?= $medico['nome']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="data_appuntamento">Data Appuntamento:</label>
            <input type="date" id="data_appuntamento" name="data_appuntamento" required>

            <button type="submit">Prenota Appuntamento</button>
        </form>

        <?php if (isset($message)): ?>
            <p class="success-message"><?= $message; ?></p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>

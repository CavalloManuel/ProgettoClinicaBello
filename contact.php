<?php
// Variabili per la gestione del modulo
$errore = '';
$successo = '';

// Controlla se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $oggetto = $_POST['oggetto'];
    $messaggio = $_POST['messaggio'];

    // Validazione dei dati
    if (empty($nome) || empty($email) || empty($oggetto) || empty($messaggio)) {
        $errore = "Tutti i campi sono obbligatori.";
    } else {
        // Invia l'email
        $to = "clinica@example.com";  // Sostituisci con la tua email
        $subject = "Nuovo messaggio da: $nome";
        $message = "Nome: $nome\nEmail: $email\nOggetto: $oggetto\n\nMessaggio:\n$messaggio";
        $headers = "From: $email";

        // Funzione mail() per inviare l'email
        if (mail($to, $subject, $message, $headers)) {
            $successo = "Il tuo messaggio è stato inviato con successo!";
        } else {
            $errore = "Si è verificato un errore nell'invio del messaggio. Riprova più tardi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contattaci - Clinica</title>
    <link rel="stylesheet" href="./style.css"> <!-- Assicurati di includere il percorso corretto -->
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Clinica Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="medici.php">I Nostri Medici</a></li>
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

    <div class="container">
        <h2>Contattaci</h2>

        <?php if ($errore): ?>
            <div class="error"><?= $errore; ?></div>
        <?php elseif ($successo): ?>
            <div class="success"><?= $successo; ?></div>
        <?php endif; ?>

        <form action="contact.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= isset($nome) ? $nome : ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($email) ? $email : ''; ?>" required>

            <label for="oggetto">Oggetto:</label>
            <input type="text" id="oggetto" name="oggetto" value="<?= isset($oggetto) ? $oggetto : ''; ?>" required>

            <label for="messaggio">Messaggio:</label>
            <textarea id="messaggio" name="messaggio" required><?= isset($messaggio) ? $messaggio : ''; ?></textarea>

            <button type="submit">Invia Messaggio</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>

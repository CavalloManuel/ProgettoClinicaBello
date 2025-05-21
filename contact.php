<?php
// Connessione al database
include 'config.php';
session_start();
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
    <title>Contattaci - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-contatti.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="medici.php"><i class="fas fa-user-md"></i> I Nostri Medici</a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> Contatti</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="auth-container">
                    <span class="auth-toggle"><i class="fas fa-user-circle"></i> Ciao, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <div class="auth-dropdown">
                        <a href="areapersonale.php"><i class="fas fa-user"></i> Area Personale</a>
                        <a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Esci</a>
                    </div>
                </li>
                <?php else: ?>
                <li class="auth-container">
                    <span class="auth-toggle"><i class="fas fa-user"></i> Accedi/Registrati</span>
                    <div class="auth-dropdown">
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> Accedi</a>
                        <a href="register.php"><i class="fas fa-user-plus"></i> Registrati</a>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <div class="container">
        <h1>Contatta la Nostra Clinica</h1>
        
            <div class="contact-info">
                <h2><i class="fas fa-info-circle"></i> Informazioni di Contatto</h2>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-content">
                        <h3>Indirizzo</h3>
                        <p>Via del Filarete, 17 - 50143 Firenze (FI)</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="info-content">
                        <h3>Telefoni</h3>
                        <p>Centralino: <a href="tel:+390612345678">3925149334</a></p>
                        <p>Emergenze: <a href="tel:+390612345679">3292620194</a></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p>Informazioni: <a href="mailto:info@clinicafirenze.it">info@clinicafirenze.it</a></p>
                        <p>Prenotazioni: <a href="mailto:prenotazioni@clinicafirenze.it">prenotazioni@clinicafirenze.it</a></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="far fa-clock"></i>
                    <div class="info-content">
                        <h3>Orari di Apertura</h3>
                        <p>Lunedì-Venerdì: 8:00-20:00</p>
                        <p>Sabato: 8:00-14:00</p>
                        <p>Domenica: Solo urgenze</p>
                    </div>
                </div>
            </div>
            <!--
            <div class="contact-form">
                <h2><i class="fas fa-paper-plane"></i> Scrivici</h2>
                <form action="contact.php" method="POST">
                    <label for="nome">Nome e Cognome*</label>
                    <input type="text" id="nome" name="nome" placeholder="Mario Rossi" required>
                    
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" placeholder="tuo@email.com" required>
                    
                    <label for="telefono">Telefono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="123 4567890">
                    
                    <label for="servizio">Servizio di interesse*</label>
                    <select id="servizio" name="servizio" required>
                        <option value="" selected disabled>Scegli il servizio</option>
                        <option value="prenotazione">Prenotazione visita</option>
                        <option value="informazioni">Informazioni generali</option>
                        <option value="urgenza">Urgenza medica</option>
                        <option value="altro">Altro</option>
                    </select>
                    
                    <label for="messaggio">Messaggio*</label>
                    <textarea id="messaggio" name="messaggio" placeholder="Scrivi qui il tuo messaggio..." required></textarea>

                    <div class="privacy">
                        <input type="checkbox" id="privacy" name="privacy" required>
                        <label for="privacy">Acconsento al trattamento dei dati personali*</label>
                    </div>
                    
                    <button type="submit"><i class="fas fa-paper-plane"></i> Invia Messaggio</button>
                </form>
            </div>
        </div>
        !-->
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2881.123456789012!2d11.2345678!3d43.7654321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132a540123456789%3A0x987654321abcdeff!2sVia%20del%20Filarete%2C%2017%2C%2050143%20Firenze%20FI!5e0!3m2!1sit!2sit!4v1234567890!5m2!1sit!2sit"
                    allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</body>
</html>
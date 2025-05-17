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

// Se l'utente è già loggato, reindirizzalo alla pagina di prenotazioni
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['prenota']) || isset($_POST['prenota_online'])) {
        // Controlla se l'utente è loggato
        if (isset($_SESSION['user_id'])) {
            header("Location: prenotazione.php");
            exit();
        } else {
            header("Location: login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #0066cc;
            --secondary: #004d99;
            --accent: #ff6b6b;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7fa;
        }
        
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        nav li {
            margin: 0 1rem;
            position: relative;
        }
        
        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            padding: 0.5rem 0;
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        .auth-container {
            position: relative;
        }
        
        .auth-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        
        .auth-toggle::after {
            content: '▼';
            font-size: 0.6rem;
            margin-left: 0.3rem;
        }
        
        .auth-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 180px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 0.5rem 0;
            z-index: 1;
        }
        
        .auth-container:hover .auth-dropdown {
            display: block;
        }
        
        .auth-dropdown a {
            display: block;
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }
        
        .auth-dropdown a:hover {
            background: #f8f9fa;
        }
        
        .banner {
            background: linear-gradient(rgba(0, 102, 204, 0.8), rgba(0, 77, 153, 0.8)), url('Images/img1.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 5rem 1rem;
            margin-bottom: 3rem;
        }
        
        .banner h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .banner p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        button {
            background: white;
            color: var(--primary);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        button:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--accent);
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 3rem 0;
        }
        
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }
        
        .img-clinica {
            max-height: 400px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .img-clinica:hover {
            transform: scale(1.02);
        }
        
        ul {
            list-style: none;
            margin: 1.5rem 0;
        }
        
        ul li {
            margin-bottom: 0.8rem;
            position: relative;
            padding-left: 1.5rem;
        }
        
        ul li::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--accent);
            position: absolute;
            left: 0;
        }
        
        .paragrafo-piccolo {
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 2rem;
            }
            
            nav ul {
                flex-wrap: wrap;
            }
            
            nav li {
                margin: 0.5rem;
            }
            
            .banner {
                padding: 3rem 1rem;
            }
            
            .banner h1 {
                font-size: 2rem;
            }
        }
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

    <div class="banner">
        <h1>Visite specialistiche e diagnostica</h1>
        <p>Un team di esperti medici è a tua disposizione.</p>
        <br>
        <form method="POST" action="index.php">
            <button type="submit" name="prenota"><i class="fas fa-calendar-check"></i> Prenota il tuo Appuntamento Online</button>
        </form>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Perché scegliere la nostra clinica</h2>
                <p>
                    Offriamo servizi medici all'avanguardia con un team di specialisti qualificati,
                    tempi di attesa ridotti e un ambiente accogliente per ogni esigenza sanitaria.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="Images/img7.png" alt="Immagine della clinica" class="img-fluid rounded shadow img-clinica">
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Centri Medici PAS</h2>
                <ul>
                    <li>Tariffe sociali</li>
                    <li>Zero tempi di attesa</li>
                    <li>Facilità di prenotazione</li>
                </ul>
                <p class="paragrafo-piccolo">
                    La Rete PAS "Pubbliche Assistenze Sanità - Centri Medici del No Profit" è il primo sistema di Assistenza Ambulatoriale Diagnostica nato in Toscana
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="Images/img6.png" alt="Immagine della clinica" class="img-fluid rounded shadow img-clinica">
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
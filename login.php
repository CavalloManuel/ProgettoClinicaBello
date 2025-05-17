<?php
// login.php
include 'config.php';
session_start();

$error = '';

if (isset($_POST['login'])) {
    //var_dump($_POST['login']);
    $email = trim($_POST['user_email']);
    $password = trim($_POST['user_password']);
    
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_surname'] = $user['surname']; //
                $_SESSION['user_email'] = $user['email']; // usati per stamparli nell'area personale
                $_SESSION['user_telefono'] = $user['telefono']; //
                $_SESSION['login'] = true; // Aggiungi questa linea
                header("Location: index.php");
                exit();
            } else {
                $error = "Password errata!";
            }
        } else {
            $error = "Utente non trovato!";
        }
        $stmt->close();
    } else {
        $error = "Inserisci email e password!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-login.css">
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
                <li><a href="index.php"><i class="fas fa-arrow-left"></i> Torna alla Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <h2><i class="fas fa-sign-in-alt"></i> Accedi al tuo account</h2>
        
        <?php if(!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="user_email" required placeholder="Inserisci la tua email">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password:</label>
                <input type="password" name="user_password" required placeholder="Inserisci la tua password">
            </div>
            
            <div class="form-group">
                <button type="submit" name="login"><i class="fas fa-sign-in-alt"></i> Accedi</button>
            </div>
        </form>
        
        <div class="register-link">
            Non hai un account? <a href="register.php"><i class="fas fa-user-plus"></i> Registrati</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
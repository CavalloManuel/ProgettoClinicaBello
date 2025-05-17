<?php
// register.php
include 'config.php';
session_start();

$error = '';

if (isset($_POST['register'])) {
    $name = trim($_POST['reg_name']);
    $surname = trim($_POST['reg_surname']);
    $email = trim($_POST['reg_email']);
    $telefono = trim($_POST['reg_telefono']);
    $password = trim($_POST['reg_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validazione dei campi
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Compila tutti i campi!";
    } elseif ($password !== $confirm_password) {
        $error = "Le password non coincidono!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Inserisci un'email valida!";
    } elseif (strlen($password) < 8) {
        $error = "La password deve avere almeno 8 caratteri!";
    } else {
        // Verifica se l'email esiste già (usando prepared statements)
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = '" . $email ."'");
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email già registrata!";
        } else {
            // Hash della password
            //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Inserimento utente (usando prepared statements)
            $insert_stmt = $conn->prepare("INSERT INTO users (name, surname, telefono, email, password) VALUES ('" . $name ."'  , '" . $surname ."' , '" . $telefono ."' , '" . $email ."' , '" . $password ."' )");


            if ($insert_stmt->execute()) {
                $_SESSION['user_id'] = $insert_stmt->insert_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_surname'] = $surname;
                $_SESSION['user_telefono'] = $telefono;
                $_SESSION['login'] = true;
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Errore durante la registrazione!";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-register.css">
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

    <div class="register-container">
        <h2><i class="fas fa-user-plus"></i> Crea un nuovo account</h2>
        
        <?php if(!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Nome:</label>
                <input type="text" name="reg_name" required value="<?php echo isset($_POST['reg_name']) ? htmlspecialchars($_POST['reg_name']) : ''; ?>" placeholder="Inserisci il tuo nome">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-user"></i> Cognome:</label>
                <input type="text" name="reg_surname" required value="<?php echo isset($_POST['reg_surname']) ? htmlspecialchars($_POST['reg_surname']) : ''; ?>" placeholder="Inserisci il tuo cognome">
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" name="reg_email" required value="<?php echo isset($_POST['reg_email']) ? htmlspecialchars($_POST['reg_email']) : ''; ?>" placeholder="esempio@email.com">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-phone"></i> Numero di telefono:</label>
                <input type="tel" name="reg_telefono" required pattern="[0-9]{10}" value="<?php echo isset($_POST['reg_telefono']) ? htmlspecialchars($_POST['reg_telefono']) : ''; ?>" placeholder="Inserisci 10 cifre">
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password (min. 8 caratteri):</label>
                <input type="password" name="reg_password" required minlength="8" placeholder="Almeno 8 caratteri">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Conferma Password:</label>
                <input type="password" name="confirm_password" required minlength="8" placeholder="Conferma la tua password">
            </div>
            
            <div class="form-group">
                <button type="submit" name="register"><i class="fas fa-user-plus"></i> Registrati</button>
            </div>
        </form>
        
        <div class="login-link">
            Hai già un account? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Accedi</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
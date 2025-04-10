<?php
// register.php
include 'config.php';
session_start();

$error = '';

if (isset($_POST['register'])) {
    $name = trim($_POST['reg_name']);
    $email = trim($_POST['reg_email']);
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
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Inserimento utente (usando prepared statements)
            $insert_stmt = $conn->prepare("INSERT INTO users (name, surname, telefono, email, password) VALUES ('" . $name ." ' , " . $surname ." , " . $telefo ." , " . $email ." , " . $hashed_password ." )");
            
            if ($insert_stmt->execute()) {
                $_SESSION['user_id'] = $insert_stmt->insert_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_surname'] = $surname;
                $_SESSION['user_telefono'] = $telefo;
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
    <title>Registrazione - Clinica</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="medici.php">I Nostri Medici</a></li>
                <li><a href="services.php">Servizi</a></li>
                <li><a href="contact.php">Contatti</a></li>
                <li><a href="index.php" style="float: right;">← Torna alla Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="register-container">
        <h2>Crea un nuovo account</h2>
        
        <?php if(!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="form-group">
                <label>Nome :</label>
                <input type="text" name="reg_name" required value="<?php echo isset($_POST['reg_name']) ? htmlspecialchars($_POST['reg_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Cognome :</label>
                <input type="text" name="reg_surname" required value="<?php echo isset($_POST['reg_surname']) ? htmlspecialchars($_POST['reg_surname']) : ''; ?>">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="reg_email" required value="<?php echo isset($_POST['reg_email']) ? htmlspecialchars($_POST['reg_email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Numero di telefono:</label>
                <input type="numero" name="reg_telefono" required minlength="10">
            </div>

            <div class="form-group">
                <label>Password (min. 8 caratteri):</label>
                <input type="password" name="reg_password" required minlength="8">
            </div>
            
            <div class="form-group">
                <label>Conferma Password:</label>
                <input type="password" name="confirm_password" required minlength="8">
            </div>
            
            <div class="form-group">
                <button type="submit" name="register">Registrati</button>
            </div>
        </form>
        
        <div class="login-link">
            Hai già un account? <a href="login.php">Accedi</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Clinica. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
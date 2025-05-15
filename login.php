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
    <title>Login - Clinica</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container h2 {
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
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="medici.php">I Nostri Medici</a></li>
                <li><a href="contact.php">Contatti</a></li>
                <li><a href="index.php" style="float: right;">← Torna alla Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        
        <?php if(!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="user_email" required>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="user_password" required>
            </div>
            
            <div class="form-group">
                <button type="submit" name="login">Accedi</button>
            </div>
        </form>
        
        <div class="register-link">
            Non hai un account? <a href="register.php">Registrati</a>
        </div>
    </div>


</body>
</html>
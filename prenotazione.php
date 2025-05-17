<?php
include 'config.php';
session_start();
$email = $medico = $data_appuntamento = "";

$prenotazione_successo = false;
$error_user_not_found = "";
$error_medico_not_found = "";
$error_data_non_valida = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = trim($_POST['password']);
    $medico = trim($_POST['medico']);
    $data_prenotazione = trim($_POST['data_prenotazione']);
    
    $today = date('Y-m-d');
    if ($data_prenotazione < $today) {
        $error_data_non_valida = "Errore: La data dell'appuntamento non può essere precedente a oggi.";
    }

    $query_user = "SELECT id FROM users WHERE password = '" . $_POST["password"] . "' AND users.id = " . $_SESSION['user_id'] ." ;"; 
    $result_user = mysqli_query($conn, $query_user) or die("Query fallita: " . mysqli_error($conn));
    if (mysqli_num_rows($result_user) > 0) {
        $user = mysqli_fetch_assoc($result_user);
        $user_id = $user['id'];
    } else {
        $error_user_not_found = "Errore: Password errata.";
    }

    $query_medico = "SELECT id FROM medici WHERE nome = '" . $_POST["medico"] . "';";
    $result_medico = mysqli_query($conn, $query_medico) or die("Query fallita: " . mysqli_error($conn));

    if (mysqli_num_rows($result_medico) > 0) {
        $medico = mysqli_fetch_assoc($result_medico);
        $medico_id = $medico['id'];
    } else {
        $error_medico_not_found = "Errore: Medico non trovato.";
    }

    if (empty($error_user_not_found) && empty($error_medico_not_found) && empty($error_data_non_valida) && !empty($password) && !empty($medico) && !empty($data_prenotazione)) {
        $query_insert = "INSERT INTO prenotazioni (user_id, medico_id, data_prenotazione) VALUES ('$user_id', '$medico_id', '$data_prenotazione');";
        $result = mysqli_query ($conn, $query_insert) or die ("Query fallita " . mysqli_error($conn));
        if ($result) {
            $prenotazione_successo = true;
        } else {
            die("Errore durante l'inserimento: " . mysqli_error($conn));
        }
    } else {
        if (empty($error_user_not_found) && empty($error_medico_not_found) && empty($error_data_non_valida)) {
            $error = "Compila tutti i campi obbligatori!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-prenotazione.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



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
    </div>

    <div class="container">
        <h2><i class="fas fa-calendar-plus"></i> Prenota il tuo appuntamento</h2>

        <?php if ($prenotazione_successo): ?>
            <div class="success-message">
                <h3><i class="fas fa-check-circle"></i> Prenotazione effettuata con successo!</h3>
                <p>Ti abbiamo riservato il tuo appuntamento.</p>
            </div>
        <?php else: ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
            <label for="password"><i class="fas fa-lock"></i> Password:</label>
            <input type="password" id="password" name="password" required placeholder="Inserisci la tua password">

            <label for="medico"><i class="fas fa-user-md"></i> Medico:</label>
            <select name="specializzazione" id="subject" required onchange="caricaMedici(this.value)">
                <option value="" selected disabled>Scegli la specializzazione</option>
                <?php
                    $query = "SELECT specializzazione FROM medici GROUP BY specializzazione";
                    $pip = mysqli_query($conn, $query) or
                    die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));

                    while ($row = $pip->fetch_assoc()) {  
                        echo "<option value='". htmlspecialchars($row['specializzazione']) ."'>". htmlspecialchars($row['specializzazione']) ."</option>";
                    }
                ?>
            </select>

            <div id="medici-lista"></div>

            <label for="data_prenotazione"><i class="fas fa-calendar-day"></i> Data Appuntamento:</label>
            <input type="date" id="data_prenotazione" name="data_prenotazione" required>
            <?php if (!empty($error_data_non_valida)): ?>
                <div class="error-message"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_data_non_valida); ?></div>
            <?php endif; ?>

            <button type="submit"><i class="fas fa-book-medical"></i> Prenota</button>
        </form>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('data_prenotazione').min = today;
            
            document.querySelector('form').addEventListener('submit', function(e) {
                const selectedDate = document.getElementById('data_prenotazione').value;
                if (selectedDate < today) {
                    e.preventDefault();
                    alert('La data dell\'appuntamento non può essere precedente a oggi.');
                    document.getElementById('data_prenotazione').focus();
                }
            });
        });

        function caricaMedici(specializzazione) {
            fetch("medici_per_specializzazione.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "specializzazione=" + encodeURIComponent(specializzazione)
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("medici-lista").innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
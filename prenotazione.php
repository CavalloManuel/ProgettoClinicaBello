<?php
include 'config.php';
session_start();
$email = $medico = $data_appuntamento = "";

$prenotazione_successo = false; // di default non è successo niente
$error_user_not_found = "";
$error_medico_not_found = "";

// Quando il form viene inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = trim($_POST['password']); //trimserve pernon salvare gli spazi nel database
    $medico = trim($_POST['medico']);
    //$commento = trim($_POST['commento']);
    $data_prenotazione = trim($_POST['data_prenotazione']);


// 1. Trova l'ID dell'utente in base alla password    
    $query_user = "SELECT id FROM users WHERE password = '" . $_POST["password"] . "' AND users.id = " . $_SESSION['user_id'] ." ;"; 
    $result_user = mysqli_query($conn, $query_user) or die("Query fallita: " . mysqli_error($conn));
    if (mysqli_num_rows($result_user) > 0) {
        $user = mysqli_fetch_assoc($result_user);
        $user_id = $user['id'];
    } else {
        $error_user_not_found = "Errore: Password errata.";
    }


// 2. Trova l'ID del medico in base al nome
    $query_medico = "SELECT id FROM medici WHERE nome = '" . $_POST["medico"] . "';";
    $result_medico = mysqli_query($conn, $query_medico) or die("Query fallita: " . mysqli_error($conn));

    if (mysqli_num_rows($result_medico) > 0) { // vuol dire che essendoci piu di una riga la query ha trovato un medico
        $medico = mysqli_fetch_assoc($result_medico); //trasforma la prima riga in array associativo
        $medico_id = $medico['id']; // prende solo l'ID e lo salva in $medico_id
    } else {
        $error_medico_not_found = "Errore: Medico non trovato.";
    }

// 3. Inserisci nella tabella prenotazioni
    if (empty($error_user_not_found) && empty($error_medico_not_found) && !empty($password) && !empty($medico) && !empty($data_prenotazione)) {
        $query_insert = "INSERT INTO prenotazioni (user_id, medico_id, data_prenotazione) VALUES ('$user_id', '$medico_id', '$data_prenotazione');";
        $result = mysqli_query ($conn, $query_insert) or die ("Query fallita " . mysqli_error($conn));
        if ($result) {
            $prenotazione_successo = true; // settiamo che la prenotazione è andata a buon fine
        } else {
            die("Errore durante l'inserimento: " . mysqli_error($conn));
        }

    } else {
        if (empty($error_user_not_found) && empty($error_medico_not_found)) {
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
    <title>Prenotazione Appuntamento - Clinica</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style-medici.css">
</head>
<body>

   <!-- pop up se medico o utente sbagliati -->
   <?php if (!empty($error_user_not_found) || !empty($error_medico_not_found)): ?>
    <script>
        alert("<?php 
            if (!empty($error_user_not_found)) echo addslashes($error_user_not_found);
            if (!empty($error_user_not_found) && !empty($error_medico_not_found)) echo '\\n';
            if (!empty($error_medico_not_found)) echo addslashes($error_medico_not_found);
        ?>");
    </script>
    <?php endif; ?>


    <header>
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

    <div class="banner">
        <h1>Visite specialistiche e diagnostica</h1>
        <p>Un team di esperti medici è a tua disposizione.</p>
        <br>
        

    </div>

    <div class="container">
        <h2>Prenota il tuo appuntamento</h2>

        

        <?php if ($prenotazione_successo): ?>
            <div class="success-message">
                <h3>Prenotazione effettuata con successo!</h3>
                <p>Ti abbiamo riservato il tuo appuntamento.</p>
            </div>
        <?php else: ?>

        <form method="post" action="<?php echo ($_SERVER["PHP_SELF"]); ?>">  
            <label for="password ">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="medico ">Medico:</label>
            <select name="specializzazione" id="subject" required onchange="caricaMedici(this.value)">    <!-- required onchange serve a mettere obbligatorio un campo e onchange è l'evento usato -->
            <option value="" selected disabled>Scegli la specializzazione</option>
            <?php
                $query = "SELECT specializzazione FROM medici group by specializzazione";
                $pip = mysqli_query($conn, $query) or
                die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));


                while ($row = $pip->fetch_assoc()) {  
                    echo "<option value='". $row['specializzazione'] ."'>". $row['specializzazione'] ."</option>";
                }

            ?>
            </select>

            <div id="medici-lista"></div>

            <script>
                function caricaMedici(specializzazione) {
                fetch("medici_per_specializzazione.php", {     // manda richiesta http all'altra pagina con il metodo POST
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"     //dichiara il tipo di dato che gli mando
                    },
                    body: "specializzazione=" + specializzazione            //gli mando la specializzazione che l'utente ha messo
                })
                .then(response => response.text())                  //dico di trasformare quello che ricevo in testo
                .then(data => {
                    document.getElementById("medici-lista").innerHTML = data; //mette la risposta nel div medici lista
                });
            }
            </script>



            <label for="data_prenotazione">Data Appuntamento:</label>
            <input type="date" id="data_prenotazione" name="data_prenotazione" required>

            <button type="submit">Prenota</button>
        </form>
        <?php endif; ?>
    </div>

</body>
</html>

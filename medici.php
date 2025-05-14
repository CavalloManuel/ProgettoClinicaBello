<?php
// Connessione al database
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I Nostri Medici - Clinica</title>
    <link rel="stylesheet" href="./style.css"> <!-- Assicurati di includere il percorso corretto -->
</head>
<body>
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
    
    <div class="container">
        <h2>I Nostri Medici</h2>
                <?php
                    $query = "SELECT specializzazione FROM medici group by specializzazione";
                    $pip = mysqli_query($conn, $query) or
                    die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));
                ?>
            
            <form method="POST" action="medici.php">
                
            <select name="specializzazione" id="subject" required onchange="listaMedici(this.value)">    
            <option value="" selected disabled>Scegli la specializzazione</option>
            <?php
                while ($row = $pip->fetch_assoc()) {  
                    echo "<option value='". $row['specializzazione'] ."'>". $row['specializzazione']."</option>";
                    }
            ?>
            </select>
            <br>
            <div id="lista"></div>
            <script>
                function listaMedici(specializzazione) {
                fetch("listamedici_per_specializzazione.php", {     // manda richiesta http all'altra pagina con il metodo POST
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"     //dichiara il tipo di dato che gli mando
                    },
                    body: "specializzazione=" + specializzazione            //gli mando la specializzazione che l'utente ha messo
                })
                .then(response => response.text())                  //dico di trasformare quello che ricevo in testo
                .then(data => {
                    document.getElementById("lista").innerHTML = data; //mette la risposta nel div lista
                });
            }
            </script>
        </form>        
    </div>



</body>
</html>
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
    <title>I Nostri Medici - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-medici.css">
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
        <h2><i class="fas fa-user-md"></i> I Nostri Medici</h2>
        
        <?php
            $query = "SELECT specializzazione FROM medici GROUP BY specializzazione";
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
                    echo "<option value='tutti'>Mostra tutti</option>";
                ?>
            </select>
        </form>
        
        <div id="lista">
            <!-- Lista medici verrà caricata qui via JavaScript -->
            <?php
                // Mostra tutti i medici all'inizio
                $query_all = "SELECT * FROM medici";
                $result_all = mysqli_query($conn, $query_all);
                
                if(mysqli_num_rows($result_all) > 0) {
                    while($medico = mysqli_fetch_assoc($result_all)) {
                        
                    }
                } else {
                    echo '<p>Nessun medico disponibile al momento</p>';
                }
            ?>
        </div>
        
        <script>
            function listaMedici(specializzazione) {
                fetch("listamedici_per_specializzazione.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "specializzazione=" + specializzazione
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("lista").innerHTML = data;
                });
            }
        </script>
    </div>
</body>
</html>
<?php
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
    <title>Area Personale - Clinica Specializzata</title>
    <link rel="stylesheet" href="./style-area.css">
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
                        <a href="index.php?logout=1"><i class="fas fa-sign-out-alt"></i> Esci</a>
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
        <h2><i class="fas fa-user"></i> Le tue informazioni</h2>
        
        <?php
        echo "<h5><i class='fas fa-handshake'></i> Benvenuto, " . $_SESSION['user_name'] . " " . $_SESSION['user_surname'] . "</h5>";
        echo "<h6><i class='fas fa-envelope'></i> La tua email: " . $_SESSION['user_email'] . "</h6>";
        echo "<h6><i class='fas fa-phone'></i> Il tuo numero di telefono: " . $_SESSION['user_telefono'] . "</h6>";

        $query = "SELECT prenotazioni.id as prenotazione_id, medici.nome, data_prenotazione
                 FROM prenotazioni 
                 JOIN medici ON medici.id = prenotazioni.medico_id
                 WHERE prenotazioni.user_id = " . $_SESSION['user_id'];

        $pip = mysqli_query($conn, $query) or
        die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));
        
        echo '<div class="visite-header">';
        echo '<h5><i class="fas fa-calendar-check"></i> Le tue visite programmate</h5>';
        echo '<button id="mostraVisite" class="btn-mostra"><i class="fas fa-eye"></i> Mostra</button>';
        echo '</div>';
        
        echo '<div id="visiteContainer" style="display:none;">';
        if(mysqli_num_rows($pip) == 0) { 
            echo "<h6><i class='fas fa-info-circle'></i> Nessuna visita programmata</h6>";
        } else {
            echo "<table>";
            echo "<tr>";
            echo "<th><i class='fas fa-user-md'></i> Medico</th>";
            echo "<th><i class='fas fa-calendar-day'></i> Giorno</th>";
            echo "<th></th>";
            echo "<th></th>";
            echo "</tr>";
            
            while ($row = $pip->fetch_assoc()) {  
                echo "<tr>";
                echo "<td>". $row['nome'] ."</td>";
                echo "<td>". $row['data_prenotazione'] ."</td>";
                echo "<td><button class='btn-elimina' onclick='eliminaVisita(".$row['prenotazione_id'].", this)'>Elimina</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        echo '</div>';
        ?>
        
        <script>
        document.getElementById("mostraVisite").addEventListener("click", function() {
            var container = document.getElementById("visiteContainer");
            if(container.style.display === "none") {
                container.style.display = "block";
                this.innerHTML = "<i class='fas fa-eye-slash'></i> Nascondi";
            } else {
                container.style.display = "none";
                this.innerHTML = "<i class='fas fa-eye'></i> Mostra";
            }
        });
        

    function eliminaVisita(id, btn) {
    if (confirm("Sei sicuro di voler eliminare questa prenotazione?")) {
        const row = btn.closest('tr'); // Trova il <tr> contenitore del bottone
        row.style.display = 'none'; // Nasconde subito la riga

        fetch('elimina_prenotazione.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'prenotazione_id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.remove(); // Rimuove la riga definitivamente

                // Se la tabella ha solo l'intestazione, mostra il messaggio
                if (document.querySelectorAll('#visiteContainer table tr').length === 1) {
                    document.querySelector('#visiteContainer').innerHTML =
                        "<h6><i class='fas fa-info-circle'></i> Nessuna visita programmata</h6>";
                }
            } else {
                // Se c'è un errore, ri-mostra la riga
                row.style.display = '';
                alert("Errore: " + data.message);
            }
        })
        .catch(error => {
            row.style.display = '';
            alert("Errore di rete: " + error.message);
        });
    }
}

        

        </script>
    </div>
</body>
</html>
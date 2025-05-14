<?php
include 'config.php';
session_start(); //cosi che carica i dati della sessione e quindi se l utente è loggato mostra "Ciao, nome utente"
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione Appuntamento - Clinica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style-areapersonale.css">
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
                        <a href="index.php?logout=1">Esci</a>
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
    <br>

    <div class="container">
        <h2>Le tue informazioni</h2>
        <ul>

            <?php
            //var_dump($_SESSION);
            echo "<h5> Benvenuto, " . $_SESSION['user_name'] . " " . $_SESSION['user_surname'] . "</h5>";
            echo "<h6> La tua email: " . $_SESSION['user_email'] . "</h6>";
            echo "<h6> Il tuo numero di telefono: " . $_SESSION['user_telefono'] . "</h6>";




            $query = " SELECT medici.nome, data_prenotazione
                       FROM prenotazioni 
                       JOIN medici ON medici.id = prenotazioni.medico_id
                       JOIN users ON users.id = prenotazioni.user_id
                       AND users.id = " . $_SESSION['user_id'] . "   
                     ";
            $pip = mysqli_query($conn, $query) or
            die ("Query fallita " . mysqli_error($conn) . " " . mysqli_errno($conn));

                        
                    echo "<h6>Le tue visite programmate  </h6>";
                    if(mysqli_num_rows($pip) == 0 ){ 
                        echo "<h6> Nessuna visita programmata </h6>";
                    }
                    else{
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>MEDICO</th>";
                        echo "<th>GIORNO</th>";
                        echo "</tr>";
                        while ($row = $pip->fetch_assoc()) {  
                            echo "<tr>";
                            echo "<td>". $row['nome'] ."</td>";
                            echo "<td>". $row['data_prenotazione'] ."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

            ?>


            
        </ul>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

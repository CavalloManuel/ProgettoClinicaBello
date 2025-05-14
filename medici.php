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
                <style>
/* Stile del select principale */
#subject {
    width: 100%;
    padding: 12px 15px;
    font-size: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233498db' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

#subject:hover {
    border-color: #3498db;
    box-shadow: 0 2px 15px rgba(52, 152, 219, 0.2);
}

#subject:focus {
    border-color: #2980b9;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

/* Stile delle option */
#subject option {
    padding: 12px 15px;
    font-size: 0.95rem;
    color: #333;
    background: #fff;
    transition: all 0.2s ease;
}

#subject option:hover {
    background-color: #3498db !important;
    color: white;
}

#subject option:checked {
    background-color: #f1f9fe;
    font-weight: 500;
    color: #3498db;
}

/* Stile per l'option disabilitata (placeholder) */
#subject option[value=""][disabled] {
    color: #95a5a6;
    font-style: italic;
}

/* Stile per il dropdown (funziona solo in alcuni browser) */
@supports (-moz-appearance:none) {
    #subject option {
        background-color: white;
    }
    
    #subject option:hover {
        background-color: #3498db;
        color: white;
    }
}

/* Animazione al cambio selezione */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

#subject {
    animation: fadeIn 1s ease;
}
</style>


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
<?php
include 'config.php';
    $specializzazione = $_POST['specializzazione'];

    $query = "SELECT nome FROM medici WHERE specializzazione = '$specializzazione' ORDER BY nome";
    $result = mysqli_query($conn, $query);
    echo "<select name='medico' id='subject'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option id='subject' value='". $row['nome'] ."'>". $row['nome']."</option>";
    }
    echo "</select>";

?>
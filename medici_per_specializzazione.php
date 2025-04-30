<?php
include 'config.php';
    $specializzazione = $_POST['specializzazione'];

    $query = "SELECT nome FROM medici WHERE specializzazione = '$specializzazione'";
    $result = mysqli_query($conn, $query);
    echo "<select name='medico'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='". $row['id'] ."'>". $row['nome']."</option>";
    }
    echo "</select>";

?>
<?php
include 'config.php';
    $specializzazione = $_POST['specializzazione'];

    $query = "SELECT nome FROM medici WHERE specializzazione = '$specializzazione' ORDER BY nome";
    $result = mysqli_query($conn, $query);
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>". $row['nome']."</li>";
    }
    echo "</ul>";
?>
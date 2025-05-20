<?php
header('Content-Type: application/json');
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prenotazione_id'])) {
    $prenotazione_id = intval($_POST['prenotazione_id']);

    // Proteggi la query con user_id per sicurezza
    $query = "DELETE FROM prenotazioni WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $prenotazione_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Prenotazione eliminata']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nessuna prenotazione trovata o non autorizzato']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore del database: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida']);
}
?>


<?php
include 'config.php';
$specializzazione = $_POST['specializzazione'];
if($specializzazione == "tutti"){
    $query = "SELECT nome, specializzazione FROM medici ORDER BY nome";
} else{
    $query = "SELECT nome, specializzazione FROM medici WHERE specializzazione = '$specializzazione' ORDER BY nome";
}
$result = mysqli_query($conn, $query);

echo '<div class="medici-lista">';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="medico-item">';
    echo '<span class="medico-nome">'.htmlspecialchars($row['nome']).'</span>';
    echo '<span class="medico-specializzazione">'.htmlspecialchars($row['specializzazione']).'</span>';
    echo '</div>';
}
echo '</div>';
?>



<style>
    
    /* Container principale */
.medici-lista {
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
}

/* Ogni item del medico */
.medico-item {
    background: white;
    padding: 15px 20px;
    margin-bottom: 10px;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    border-left: 4px solid #3498db;
}

.medico-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    background: #f8f9fa;
}

/* Nome medico */
.medico-nome {
    font-size: 1.1rem;
    color: #2c3e50;
    font-weight: 100;
}

/* Specializzazione */
.medico-specializzazione {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .medico-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>
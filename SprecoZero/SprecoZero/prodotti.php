<?php
require_once 'config.php';

$sql = "SELECT * FROM prodotti_t WHERE Disponibilita > 0";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Nome: " . $row['Nome'] . "<br>";
    echo "Descrizione: " . $row['Descrizione'] . "<br>";
    echo "Prezzo Sconto: " . $row['Prezzo_Sconto'] . "€<br>";
    echo "Disponibilità: " . $row['Disponibilita'] . "<br>";
    echo "<p><a href='effettua_ordine.php?id=" . $row['ID_Prodotto'] . "'>Ordina ora</a></p>";
    echo "<hr>";
}
?>

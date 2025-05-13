<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $idProdotto = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];
    $idCliente = $_SESSION['user_id'];

    // Inserire l'ordine
    $sql = "INSERT INTO ordini_t (ID_Prodotto, ID_Utente, Quantita) VALUES (:id_prodotto, :id_utente, :quantita)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_prodotto', $idProdotto);
    $stmt->bindParam(':id_utente', $idCliente);
    $stmt->bindParam(':quantita', $quantita);

    if ($stmt->execute()) {
        echo "Ordine effettuato con successo!";
    } else {
        echo "Errore nell'effettuare l'ordine.";
    }
}
?>

<form method="POST">
    ID Prodotto: <input type="text" name="id_prodotto" required><br>
    Quantità: <input type="number" name="quantita" required><br>
    <input type="submit" value="Ordina Prodotto">
</form>

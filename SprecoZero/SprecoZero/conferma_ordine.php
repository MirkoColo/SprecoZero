<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_utente'])) {
        header('Location: login.php');
        exit;
    }

    $id_utente = $_SESSION['id_utente'];
    $dati_ordine = json_decode($_POST['dati_ordine'], true);
    $data_ordine = date('Y-m-d H:i:s');

    foreach ($dati_ordine as $item) {
        $id_prodotto = intval($item['id']);
        $quantita = intval($item['quantita']);

        // Inserisce l’ordine
        $stmt = mysqli_prepare($conn, "INSERT INTO ordini_t (ID_Prodotto, ID_Utente, Quantita, Data_Ordine) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iiis', $id_prodotto, $id_utente, $quantita, $data_ordine);
        mysqli_stmt_execute($stmt);

        // Aggiorna disponibilità
        mysqli_query($conn, "UPDATE prodotti_t SET Disponibilita = GREATEST(Disponibilita - $quantita, 0) WHERE ID_Prodotto = $id_prodotto");
    }

    // Svuota il carrello
    unset($_SESSION['carrello']);

    // ✅ Reindirizza con messaggio di successo
    header('Location: carrello.php?success=1');
    exit;
}
?>

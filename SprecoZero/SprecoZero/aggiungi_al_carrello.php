<?php
session_start();

// Inizializza il carrello se non esiste
if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

// Recupera l'ID del prodotto dalla query string
if (isset($_GET['id'])) {
    $id_prodotto = (int) $_GET['id'];

    // Aggiunge il prodotto al carrello (incrementa se già esiste)
    if (isset($_SESSION['carrello'][$id_prodotto])) {
        $_SESSION['carrello'][$id_prodotto]++;
    } else {
        $_SESSION['carrello'][$id_prodotto] = 1;
    }
}

// Reindirizza alla pagina dei prodotti
header('Location: visualizza_prodotti.php');
exit;
?>

<?php
include "topbar.php";
require_once 'config.php'; // Include il file di configurazione per la connessione al database

// Verifica se l'utente è loggato (sessione attiva)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    // Raccogli i dati dal form
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $prezzoOriginale = $_POST['prezzo_originale'];
    $prezzoSconto = $_POST['prezzo_sconto'];
    $disponibilita = $_POST['disponibilita'];
    $immagine = $_POST['immagine']; // Percorso dell'immagine (opzionale)

    // Recupera l'ID del venditore dalla sessione
    $idVenditore = $_SESSION['user_id'];

    // Crea la query SQL per inserire il prodotto nel database
    $sql = "INSERT INTO prodotti_t (Nome, Descrizione, Prezzo_Originale, Prezzo_Sconto, Disponibilita, ID_Venditore, Immagine) 
            VALUES ('$nome', '$descrizione', '$prezzoOriginale', '$prezzoSconto', '$disponibilita', '$idVenditore', '$immagine')";
    
    // Esegui la query SQL
    if (mysqli_query($conn, $sql)) {
        echo "Prodotto aggiunto con successo!";
    } else {
        echo "Errore nell'aggiunta del prodotto: " . mysqli_error($conn);
    }
}
?>

<!-- Aggiungi questo dentro il tag <head> del tuo file -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .form-prodotto {
        width: 50%;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-prodotto label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    .form-prodotto input,
    .form-prodotto textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .form-prodotto input[type="submit"] {
        background-color: #2ecc71;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
    }

    .form-prodotto input[type="submit"]:hover {
        background-color: #27ae60;
    }

    .form-prodotto textarea {
        height: 120px;
    }

    h2 {
        text-align: center;
        color: #333;
    }
</style>

<!-- Modulo per l'inserimento di un prodotto -->
<form method="POST" class="form-prodotto">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required><br>

    <label for="descrizione">Descrizione:</label>
    <textarea name="descrizione" id="descrizione" required></textarea><br>

    <label for="prezzo_originale">Prezzo Originale (€):</label>
    <input type="number" step="0.01" name="prezzo_originale" id="prezzo_originale" required><br>

    <label for="prezzo_sconto">Prezzo Sconto (€):</label>
    <input type="number" step="0.01" name="prezzo_sconto" id="prezzo_sconto" required><br>

    <label for="disponibilita">Disponibilità:</label>
    <input type="number" name="disponibilita" id="disponibilita" required><br>

    <label for="immagine">Immagine (URL):</label>
    <input type="text" name="immagine" id="immagine"><br>

    <input type="submit" value="Aggiungi Prodotto" class="btn-submit">
</form>

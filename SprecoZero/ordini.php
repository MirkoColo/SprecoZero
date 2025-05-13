<?php
session_start();
include('config.php');
include('topbar.php');

if (!isset($_SESSION['id_utente'])) {
    die("Devi essere loggato per visualizzare i tuoi ordini. <a href='accesso.php'>Accedi</a>");
}

$id_utente = $_SESSION['id_utente'];
$query = "SELECT o.ID_Ordine, p.Nome, o.Quantita, o.Data_Ordine 
          FROM ordini_t o 
          JOIN prodotti_t p ON o.ID_Prodotto = p.ID_Prodotto 
          WHERE o.ID_Utente = $id_utente";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I tuoi ordini - SprecoZero</title>
    <link rel="stylesheet" href="style.css"> <!-- Aggiungi il file CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-top: 30px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2ecc71;
            color: white;
            font-size: 18px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-orders {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d;
        }

        .btn {
            display: inline-block;
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin: 20px auto;
            text-align: center;
        }

        .btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <h2>I tuoi ordini</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Prodotto</th>
                <th>Quantità</th>
                <th>Data Ordine</th>
            </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['Nome']) ?></td>
                <td><?= $row['Quantita'] ?></td>
                <td><?= $row['Data_Ordine'] ?></td>
            </tr>
        <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-orders">Non hai ancora effettuato ordini.</p>
        <a href="index.php" class="btn">Torna alla Home</a>
    <?php endif; ?>
</body>
</html>

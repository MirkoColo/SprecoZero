<?php
session_start();
include('config.php');
include('topbar.php');

// Gestione ricerca
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM prodotti_t WHERE Nome LIKE '%$search%'"; // Cerca per nome del prodotto
} else {
    $query = "SELECT * FROM prodotti_t"; // Mostra tutti i prodotti
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Prodotti - SprecoZero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0px;
        }

        h2 {
            text-align: center;
            font-size: 2em;
            color: #2c3e50;
        }

        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 1.1em;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-box button {
            padding: 10px 20px;
            font-size: 1.1em;
            cursor: pointer;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .search-box button:hover {
            background-color: #27ae60;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .product-item {
            background-color: white;
            padding: 15px;
            margin: 10px;
            width: 250px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-item h3 {
            font-size: 1.2em;
            color: #2c3e50;
        }

        .product-item p {
            font-size: 1em;
            color: #7f8c8d;
        }

        .product-item button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .product-item button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <h2>Seleziona un prodotto per effettuare un ordine</h2>

    <div class="search-box">
        <form method="post">
            <input type="text" name="search" placeholder="Cerca prodotto..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cerca</button>
        </form>
    </div>

    <div class="product-list">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-item">
                <h3><?= htmlspecialchars($row['Nome']) ?></h3>
                <p><strong>Prezzo sconto:</strong> €<?= number_format($row['Prezzo_Sconto'], 2) ?></p>
                <p><strong>Disponibilità:</strong> <?= $row['Disponibilita'] ?></p>
                <a href="effettua_ordine.php?id=<?= $row['ID_Prodotto'] ?>">
                    <button>Ordina</button>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>

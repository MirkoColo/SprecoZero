<?php
session_start();
include('config.php');
include('topbar.php');

// Inizializza carrello se non esiste
if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

// Gestione aggiunta al carrello
$messaggio = '';
if (isset($_GET['add_to_cart'])) {
    $id_prodotto = intval($_GET['add_to_cart']);
    if (!isset($_SESSION['carrello'][$id_prodotto])) {
        $_SESSION['carrello'][$id_prodotto] = 1;
    } else {
        $_SESSION['carrello'][$id_prodotto]++;
    }
    $messaggio = "Prodotto aggiunto al carrello!";
}

// Gestione ricerca
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    // Modifica la query per escludere i prodotti con disponibilità zero
    $query = "SELECT * FROM prodotti_t WHERE Nome LIKE '%$search%' AND Disponibilita > 0";
} else {
    // Modifica la query per escludere i prodotti con disponibilità zero
    $query = "SELECT * FROM prodotti_t WHERE Disponibilita > 0";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Prodotti - SprecoZero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .messaggio {
            text-align: center;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin: 10px auto;
            width: 50%;
            border-radius: 5px;
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

        .search-box select {
            padding: 10px;
            font-size: 1.1em;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-left: 10px;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .product-item {
            background-color: white;
            padding: 15px;
            margin: 10px;
            width: 250px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: opacity 0.3s, transform 0.3s;
        }

        .product-item button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-item button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <h2>Seleziona un prodotto per effettuare un ordine</h2>

    <?php if ($messaggio): ?>
        <div class="messaggio" id="message"><?= htmlspecialchars($messaggio) ?></div>
    <?php endif; ?>

    <div class="search-box">
        <input type="text" id="liveSearch" placeholder="Cerca prodotto..." onkeyup="searchProducts()">
        <select id="sortOrder" onchange="searchProducts()">
            <option value="name">Ordina per nome</option>
            <option value="price_asc">Ordina per prezzo crescente</option>
            <option value="price_desc">Ordina per prezzo decrescente</option>
        </select>
    </div>

    <div class="product-list" id="productList">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-item" data-titolo="<?= htmlspecialchars($row['Nome']) ?>" data-prezzo="<?= htmlspecialchars($row['Prezzo_Sconto']) ?>">
                <h3><?= htmlspecialchars($row['Nome']) ?></h3>
                <p><strong>Prezzo sconto:</strong> €<?= number_format($row['Prezzo_Sconto'], 2) ?></p>
                <p><strong>Disponibilità:</strong> <?= $row['Disponibilita'] ?></p>
                <a href="visualizza_prodotti.php?add_to_cart=<?= $row['ID_Prodotto'] ?>">
                    <button>Ordina</button>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        let allItems = [];
        document.querySelectorAll('.product-item').forEach(item => {
            allItems.push(item);
        });

        // Funzione per cercare i prodotti in modo dinamico
        function searchProducts() {
            const searchQuery = document.getElementById('liveSearch').value.toLowerCase();
            const items = document.querySelectorAll('.product-item');
            let filteredItems = [];

            // Filtra i prodotti in base alla ricerca
            allItems.forEach(function(item) {
                const titolo = item.getAttribute('data-titolo').toLowerCase();
                if (titolo.includes(searchQuery)) {
                    filteredItems.push(item);
                }
            });

            // Se la ricerca è vuota, mostra tutti i prodotti
            if (searchQuery === "") {
                filteredItems = allItems;
            }

            // Applica l'ordinamento se necessario
            filteredItems = sortProducts(filteredItems);

            // Rimuove tutti gli elementi dal DOM
            const productList = document.querySelector('#productList');
            productList.innerHTML = '';

            // Aggiunge i prodotti filtrati/ordinati
            filteredItems.forEach(function(item) {
                productList.appendChild(item);
            });
        }

        // Funzione per ordinare i prodotti
function sortProducts(items) {
    const sortBy = document.getElementById('sortOrder').value;

    if (sortBy === 'name') {
        items.sort((a, b) => {
            const nameA = a.querySelector('h3').innerText.toLowerCase();
            const nameB = b.querySelector('h3').innerText.toLowerCase();
            return nameA.localeCompare(nameB);
        });
    } else if (sortBy === 'price_asc') {
        items.sort((a, b) => {
            // Estrai il prezzo (in formato numerico) da ciascun prodotto
            const priceA = parseFloat(a.querySelector('p').innerText.replace('€', '').trim());
            const priceB = parseFloat(b.querySelector('p').innerText.replace('€', '').trim());
            return priceA - priceB;
        });
    } else if (sortBy === 'price_desc') {
        items.sort((a, b) => {
            // Estrai il prezzo (in formato numerico) da ciascun prodotto
            const priceA = parseFloat(a.querySelector('p').innerText.replace('€', '').trim());
            const priceB = parseFloat(b.querySelector('p').innerText.replace('€', '').trim());
            return priceB - priceA;
        });
    }

    return items;
}


        // Nascondi il messaggio dopo 3 secondi
        if (document.getElementById('message')) {
            setTimeout(() => {
                document.getElementById('message').style.display = 'none';
            }, 3000);
        }
    </script>

</body>
</html>

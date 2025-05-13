<?php
session_start();
include('config.php');
include('topbar.php');

$carrello = $_SESSION['carrello'] ?? [];

echo "<h2>Il tuo carrello</h2>";

if (empty($carrello)) {
    echo "<p>Il carrello è vuoto.</p>";
    exit;
}
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div style="background-color: #dff0d8; color: #3c763d; padding: 10px; text-align: center; border-radius: 5px; margin: 10px;">
        ✅ Ordine confermato con successo!
    </div>
<?php endif; ?>

<?php
$ids = implode(',', array_keys($carrello));
$query = "SELECT * FROM prodotti_t WHERE ID_Prodotto IN ($ids)";
$result = mysqli_query($conn, $query);

$prodotti = [];
$totale = 0;

echo "<form method='post' action='conferma_ordine.php'>";
echo "<ul>";

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['ID_Prodotto'];
    $quantita = $carrello[$id];
    $prezzo = $row['Prezzo_Sconto'];
    $nome = $row['Nome'];
    $totaleProdotto = $quantita * $prezzo;
    $totale += $totaleProdotto;

    $prodotti[] = [
        'id' => $id,
        'nome' => $nome,
        'quantita' => $quantita,
        'prezzo_unitario' => $prezzo,
        'totale' => $totaleProdotto
    ];

    echo "<li>{$nome} - Quantità: $quantita - Prezzo totale: €" . number_format($totaleProdotto, 2) . "</li>";
}

echo "</ul>";
echo "<p><strong>Totale ordine:</strong> €" . number_format($totale, 2) . "</p>";

// Passa i dati dell'ordine in JSON nel form
$jsonProdotti = htmlspecialchars(json_encode($prodotti), ENT_QUOTES);
echo "<input type='hidden' name='dati_ordine' value='{$jsonProdotti}'>";
echo "<input type='hidden' name='totale' value='{$totale}'>";
echo "<button type='submit'>Conferma Ordine</button>";
echo "</form>";
?>

<?php
session_start();
include('config.php');
include('topbar.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>SprecoZero - Cibo a Prezzo Scontato</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            margin-top: 30px;
            color: #2c3e50;
        }

        .contenuto {
            background-color: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .contenuto h3 {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="contenuto">
        <h2>Benvenuto su SprecoZero!</h2>
        <p>SprecoZero è un'azienda impegnata nella riduzione degli sprechi alimentari. Offriamo ai nostri clienti l'opportunità di acquistare cibo invenduto a prezzo scontato, contribuendo così alla lotta contro lo spreco e favorendo il consumo responsabile.</p>
        
        <h3>La nostra missione</h3>
        <p>La missione di SprecoZero è quella di connettere supermercati, ristoranti e consumatori per permettere a tutti di acquistare cibo che altrimenti verrebbe sprecato. Vogliamo ridurre l'impatto ambientale del cibo inutilizzato e contribuire al benessere delle persone.</p>
        
        <h3>Come funziona</h3>
        <p>1. I supermercati e i ristoranti caricano i loro prodotti invenduti sul nostro sito.</p>
        <p>2. I consumatori possono acquistare questi prodotti a un prezzo scontato.</p>
        <p>3. Ogni acquisto contribuisce a ridurre lo spreco alimentare e a risparmiare denaro.</p>
    </div>

    <div class="contenuto">
        <h3>Perché scegliere SprecoZero?</h3>
        <ul>
            <li>Riduci lo spreco alimentare.</li>
            <li>Acquista prodotti freschi a prezzi più bassi.</li>
            <li>Sostieni supermercati e ristoranti locali.</li>
        </ul>
    </div>
</body>
</html>

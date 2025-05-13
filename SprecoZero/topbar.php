<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .topbar {
        background-color: #2c3e50;
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: Arial, sans-serif;
    }

    .topbar h1 {
        margin: 0;
        font-size: 24px;
    }

    .topbar nav a {
        color: white;
        margin-left: 15px;
        text-decoration: none;
    }

    .topbar nav a:hover {
        text-decoration: underline;
    }

    .topbar-right {
        display: flex;
        align-items: center;
    }
</style>

<div class="topbar">
    <h1>SprecoZero</h1>
    <div class="topbar-right">
        <nav>
            <a href="index.php">Home</a>
            
            <?php if (isset($_SESSION['id_utente'])): // Se l'utente è loggato ?>                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'venditore'): ?>
                    <!-- Se il ruolo è venditore, mostra il link per caricare un prodotto -->
                    <a href="carica_prodotto.php">Carica Prodotto</a>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'cliente'): ?>
                    <!-- Se il ruolo è cliente, mostra i link per effettuare ordine e visualizzare ordini -->
                    <a href="effettua_ordine.php">Effettua Ordine</a> 
                    <a href="ordini.php">I tuoi ordini</a>
                <?php endif; ?>
                <!-- Link per il logout (comune sia per venditori che per clienti) -->
                <a href="logout.php">Logout</a> 
            <?php else: // Se l'utente NON è loggato ?>
                <a href="accesso.php">Login</a> 
                <a href="registrazione.php">Registrati</a> 
            <?php endif; ?>
        </nav>
    </div>
</div>

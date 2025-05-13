<?php
session_start();
include('config.php');

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $ruolo = $_POST['ruolo'];

    if (!empty($nome) && !empty($email) && !empty($password) && ($ruolo == 'cliente' || $ruolo == 'venditore')) {
        $query = "INSERT INTO utenti_t (Nome, Email, Pwd, Ruolo) VALUES ('$nome', '$email', '$password', '$ruolo')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php?success=1");
            exit();
        } else {
            $errore = 'Errore nella registrazione. L\'email potrebbe essere già in uso.';
        }
    } else {
        $errore = 'Compila tutti i campi.';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - SprecoZero</title>
</head>
<body>
    <h2>Registrati</h2>
    <?php if ($errore) echo "<p style='color:red;'>$errore</p>"; ?>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome completo" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="ruolo" required>
            <option value="">Seleziona ruolo</option>
            <option value="cliente">Cliente</option>
            <option value="venditore">Venditore</option>
        </select><br>
        <button type="submit">Registrati</button>
    </form>
    <p>Hai già un account? <a href="login.php">Accedi</a></p>
</body>
</html>

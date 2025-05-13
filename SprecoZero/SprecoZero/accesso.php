<?php
session_start();
include('config.php');

$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM utenti_t WHERE Email = '$email' AND Pwd = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $utente = mysqli_fetch_assoc($result);
        $_SESSION['id_utente'] = $utente['ID_Utente'];
        $_SESSION['nome'] = $utente['Nome'];
        $_SESSION['role'] = $utente['Ruolo'];
        header("Location: index.php");
        exit();
    } else {
        $errore = "Email o password errati.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login - SprecoZero</title>
</head>
<body>
    <h2>Accedi</h2>
    <?php if (isset($_GET['success'])) echo "<p style='color:green;'>Registrazione completata. Ora puoi accedere.</p>"; ?>
    <?php if ($errore) echo "<p style='color:red;'>$errore</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Non hai un account? <a href="registrazione.php">Registrati</a></p>
</body>
</html>

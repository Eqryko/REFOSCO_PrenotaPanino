<?php

session_start();

// === DATI DELL'ORDINE ===
$nome = $_SESSION["nome"];
$fidelity = isset($_SESSION["fidelity_ok"]) && $_SESSION["fidelity_ok"];

// Connessione al DataBase
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Seleziona il database
if (!$conn->select_db("paninaro")) {
    die("<p style='color:red;'> Impossibile selezionare il database: " . $conn->error . "</p>");
}

// Se è andato tutto bene
echo "<p style='color:red; z-index:9999'> Database selezionato correttamente!</p>";

// --- RECUPERO DATI UTENTE DAL DATABASE ---
$sql = "SELECT nome, email, telefono, fidelity, data_registrazione 
        FROM Utente 
        WHERE nome = '$nome'";

$result = $conn->query($sql);

// valori di default
$emailDB = "Non disponibile";
$telefonoDB = "Non disponibile";
$fidelityDB = 0;
$dataRegDB = "Non disponibile";

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $emailDB = $row["email"];
    $telefonoDB = $row["telefono"];
    $fidelityDB = $row["fidelity"];
    $dataRegDB = $row["data_registrazione"];
}

$conn->close();

// === CONTATORE DI VISUALIZZAZIONI BASATO SU COOKIE ===
if (isset($_COOKIE["visualizzazioni"])) {
    $count = (int) $_COOKIE["visualizzazioni"] + 1;
} else {
    $count = 1; // prima visita
}

// aggiorna il cookie (dura 1 anno)
setcookie("visualizzazioni", $count, time() + (365 * 24 * 60 * 60), "/");

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Scontrino</title>
    <link rel="stylesheet" href="general.css">
</head>
<body>
    <div class="lava-bg">
        <div class="lava-blob"></div>
        <div class="lava-blob"></div>
        <div class="lava-blob"></div>
        <div class="lava-blob"></div>
        <div class="lava-blob"></div>
    </div>
    <img class="logo" src="../media/greenmantis.png">
    <header class="Nav">
        <a href="https://www.itisrossi.edu.it/" target="_blank">ITIS Rossi</a>
        <a href="https://github.com/Eqryko" target="_blank"> GitHub Profile</a>
        <a href="https://github.com/Eqryko/REFOSCO_PrenotaPanino" target="_blank"> GitHub Project </a>
    </header>
    <div class="Main">
        <h1>Utente</h1>
        <p><b>Nome:</b> <?= $nome ?></p>
        <p><b>Email:</b> <?= $emailDB ?></p>
        <p><b>Telefono:</b> <?= $telefonoDB ?></p>
        <p><b>Registrato il:</b> <?= $dataRegDB ?></p>

        <?php if ($fidelityDB): ?>
            <p style="color:lime;">Sconto Fidelity del 20% applicato</p>
        <?php else: ?>
            <p style="color:red;">Nessuno sconto applicato</p>
        <?php endif; ?>


        <p>Visualizzazioni: </p><?= $count ?>
    </div>
</body>
</html>
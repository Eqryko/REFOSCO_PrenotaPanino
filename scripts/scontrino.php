<?php

session_start();

// === DATI DELL'ORDINE ===
$nome = $_SESSION["nome"];
$data = $_SESSION["data"];
$tempo = $_SESSION["tempo"];
$pane = $_SESSION["pane"];
$proteina = $_SESSION["proteina"];
$verdura = $_SESSION["verdura"];
$salse = $_SESSION["salse"];
$aggiunte = $_SESSION["aggiunte"];
$prezzo = $_SESSION["prezzo"];
$fidelity = isset($_SESSION["fidelity_ok"]) && $_SESSION["fidelity_ok"];
$oggi = date("d/m/Y H:i:s");

// === SCRITTURA SCONTRINO ===
$fp = fopen("scontrino.txt", "a");
fwrite($fp, "=====================\n");
fwrite($fp, "Scontrino - $oggi\n");
fwrite($fp, "Cliente: $nome\n");
fwrite($fp, "Pane: $pane | Proteina: $proteina | Verdura: $verdura \n");
fwrite($fp, "Salse: " . implode(", ", $salse) . "\n");
fwrite($fp, "Aggiunte: " . implode(", ", $aggiunte) . "\n");
fwrite($fp, "Totale: " . number_format($prezzo, 2) . " €\n");
if ($fidelity) fwrite($fp, "(Sconto Fidelity applicato)\n");
fwrite($fp, "=====================\n\n");
fclose($fp);

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


// creare una tabella, uno script, eseguirlo

$sql = "CREATE TABLE IF NOT EXISTS Ordini (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    pane VARCHAR(30) NOT NULL,
    proteina VARCHAR(30) NOT NULL,
    verdura VARCHAR(30) NOT NULL,
    salse TEXT,
    aggiunte TEXT,
    prezzo DECIMAL(6,2) NOT NULL,
    fidelity TINYINT(1) DEFAULT 0,
    data_consegna DATE NOT NULL,
    ora_consegna TIME NOT NULL,
    data_ordine TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS Utente (
    nome VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100),
    telefono VARCHAR(20),
    fidelity TINYINT(1) DEFAULT 0,
    data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// INSERT 1
$sql = "INSERT INTO Utente (nome, email, telefono, fidelity)
        VALUES ('Enrico Refosco', 'enricoorefosco@gmail.com', '3473044594', 1)";
$conn->query($sql);

// INSERT 2
$sql = "INSERT INTO Utente (nome, email, telefono, fidelity)
        VALUES ('Alex Munaro', 'alexmunaro22@gmail.com', '3923819874', 0)";
$conn->query($sql);

// INSERT 3
$sql = "INSERT INTO Utente (nome, email, telefono, fidelity)
        VALUES ('Edoardo Tozzi', 'edo.tozzi@example.com', '3391122334', 1)";
$conn->query($sql);

echo "Dati inseriti!";

$conn->close();

// === CONTATORE DI VISUALIZZAZIONI BASATO SU COOKIE ===
if (isset($_COOKIE["visualizzazioni"])) {
    $count = (int)$_COOKIE["visualizzazioni"] + 1;
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
        <h1>Ordine Confermato ✅</h1>
        <p><b>Data dell'ordine:</b> <?= $oggi ?></p>
        <p><b>Consegna richiesta:</b> <?= "$data $tempo" ?></p>
        <h2>Riepilogo Panino</h2>
        <table border="1" align="center" cellpadding="8">
            <tr><th>Campo</th><th>Valore</th></tr>
            <tr><td>Nome</td><td><?= $nome ?></td></tr>
            <tr><td>Pane</td><td><?= $pane ?></td></tr>
            <tr><td>Proteina</td><td><?= $proteina ?></td></tr>
            <tr><td>Verdura</td><td><?= $verdura ?></td></tr>
            <tr><td>Salse</td><td><?= implode(", ", $salse) ?></td></tr>
            <tr><td>Aggiunte</td><td><?= implode(", ", $aggiunte) ?></td></tr>
            <tr><td><b>Totale</b></td><td><b><?= number_format($prezzo, 2) ?> €</b></td></tr>
        </table>
        <?php if ($fidelity): ?>
            <p style="color:lime;">Sconto Fidelity del 20% applicato</p>
        <?php else: ?>
            <p style="color:red;">Nessuno sconto applicato</p>
        <?php endif; ?>


        <p>Visualizzazioni: </p><?= $count ?>
    </div>
</body>
</html>

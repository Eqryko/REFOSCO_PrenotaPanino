<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Dati principali
    $nome = htmlspecialchars($_POST["nome"]);
    $data = htmlspecialchars($_POST["data"]);
    $tempo = htmlspecialchars($_POST["tempo"]);
    $pane = htmlspecialchars($_POST["pane"]);
    $proteina = htmlspecialchars($_POST["proteina"]);
    $salse = isset($_POST["salsa"]) ? $_POST["salsa"] : [];
    $aggiunte = isset($_POST["agg"]) ? $_POST["agg"] : [];
    $haFidelity = isset($_POST["haFidelity"]); // true se selezionato

    // Calcolo prezzo base
    $prezzo = 8.00 + count($salse) * 0.5 + count($aggiunte) * 0.7;

    // Salva tutto in sessione
    $_SESSION["nome"] = $nome;
    $_SESSION["data"] = $data;
    $_SESSION["tempo"] = $tempo;
    $_SESSION["pane"] = $pane;
    $_SESSION["proteina"] = $proteina;
    $_SESSION["salse"] = $salse;
    $_SESSION["aggiunte"] = $aggiunte;
    $_SESSION["prezzo"] = $prezzo;

    // Se NON ha la fidelity va direttamente allo scontrino
    if (!$haFidelity) {
        $_SESSION["fidelity_ok"] = false; // assicura che resti disattivata
        header("Location: scontrino.php");
        exit;
    }

    // Se ha selezionato la fidelity segna che deve inserire il codice
    $_SESSION["attesa_fidelity"] = true;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserisci Codice Fidelity</title>
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
        <h1>Codice Fidelity</h1>
        <form action="fidelty.php" method="post">
            <p><b>Inserisci il tuo codice Fidelity per ottenere lo sconto del 20%</b></p>
            <input type="text" name="codice" maxlength="20" required>
            <br><br>
            <input type="submit" value="Conferma Codice">
        </form>
    </div>
</body>
</html>
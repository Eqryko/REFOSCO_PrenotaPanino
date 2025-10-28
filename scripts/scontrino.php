<?php
session_start();

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

// Scrittura su file “scontrino.txt”
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
    </div>
</body>
</html>

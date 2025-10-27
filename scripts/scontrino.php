<?php
session_start();

if (!isset($_SESSION["ordine"])) {
    die("<h2>Errore: nessun ordine trovato.</h2>");
}

$ordine = $_SESSION["ordine"];
$prezzo_base = 8.00;

// Lettura file codici validi
$codici_validi = file("codici.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$codice_inserito = trim($_POST["codice"]);
$sconto = 0;

// Verifica codice fidelity
if (in_array($codice_inserito, $codici_validi)) {
    $sconto = 0.20; // 20% di sconto
    $esito = "Codice Fidelity valido! Hai ottenuto uno sconto del 20%.";
} else {
    $esito = "Codice Fidelity non valido o assente.";
}

// Calcolo prezzo finale
$totale = $prezzo_base - ($prezzo_base * $sconto);
$data_ordine = date("d/m/Y H:i:s");

// --- Scrittura su file (scontrino.txt)
$file = fopen("scontrino.txt", "a");
fwrite($file, "----- Nuovo Ordine -----\n");
foreach ($ordine as $chiave => $valore) {
    fwrite($file, ucfirst($chiave) . ": $valore\n");
}
fwrite($file, "Prezzo finale: €" . number_format($totale, 2) . "\n");
fwrite($file, "Data ordine: $data_ordine\n");
fwrite($file, "-------------------------\n\n");
fclose($file);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma Ordine</title>
    <link rel="stylesheet" href="general.css">
</head>
<body>
    <div class="Main">
        <h1>Ordine Confermato</h1>
        <p><?= $esito ?></p>
        <p><b>Data ordine:</b> <?= $data_ordine ?></p>
        <p><b>Data richiesta consegna:</b> <?= htmlspecialchars($ordine["data"]) ?> alle <?= htmlspecialchars($ordine["ora"]) ?></p>

        <table border="1" cellpadding="10" style="margin:auto; background-color:#000000aa; color:white;">
            <tr><th>Campo</th><th>Valore</th></tr>
            <?php foreach ($ordine as $k => $v): ?>
                <tr>
                    <td><?= ucfirst($k) ?></td>
                    <td><?= htmlspecialchars($v) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><td><b>Prezzo finale</b></td><td><b>€<?= number_format($totale, 2) ?></b></td></tr>
        </table>

        <p><i>Scontrino salvato su file server.</i></p>
    </div>
</body>
</html>
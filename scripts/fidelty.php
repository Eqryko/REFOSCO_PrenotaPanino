<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codiceInserito = trim($_POST["codice"]);
    $valido = false;

    // Legge i codici validi da file
    $file = fopen("codici.txt", "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            if (trim($line) === $codiceInserito) {
                $valido = true;
                break;
            }
        }
        fclose($file);
    }

    // Applica sconto se valido
    if ($valido) {
        $_SESSION["prezzo"] *= 0.8;
        $_SESSION["fidelity_ok"] = true;
    } else {
        $_SESSION["fidelity_ok"] = false;
    }

    header("Location: scontrino.php");
    exit;
} else {
    echo "Accesso non autorizzato!";
}
?>

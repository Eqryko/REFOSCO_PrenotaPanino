<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // inviati dal form
    $nome = trim($_POST["nome"]);
    $data = $_POST["data"];
    $ora = $_POST["tempo"];
    $pane = $_POST["pane"];
    $proteina = $_POST["proteina"];
    $verdura = $_POST["verdura"] ?? "Nessuna";
    $salse = isset($_POST["salsa"]) ? implode(", ", $_POST["salsa"]) : "Nessuna";
    $aggiunte = isset($_POST["agg"]) ? implode(", ", $_POST["agg"]) : "Nessuna";

    // di base
    if (strlen($nome) < 3) {
        die("<h2>Errore: il nome deve contenere almeno 3 caratteri.</h2>");
    }

    $oggi = date("Y-m-d");
    if ($data < $oggi) {
        die("<h2>Errore: la data di prenotazione non può essere nel passato.</h2>");
    }

    // Salva i dati in sessione per usarli nella pagina successiva
    session_start();
    $_SESSION["ordine"] = [
        "nome" => $nome,
        "data" => $data,
        "ora" => $ora,
        "pane" => $pane,
        "proteina" => $proteina,
        "verdura" => $verdura,
        "salse" => $salse,
        "aggiunte" => $aggiunte
    ];
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Codice Fidelity</title>
    <link rel="stylesheet" href="general.css">
</head>
<body>
    <div class="Main">
        <h1>Inserisci Codice Fidelity</h1>
        <form action="scontrino.php" method="post">
            <p>Hai un codice fidelity? Inseriscilo per ottenere uno sconto del 20%!</p>
            <input type="text" name="codice" placeholder="Inserisci codice..." required>
            <br><br>
            <input type="submit" value="Conferma Ordine">
        </form>
    </div>
</body>
</html>

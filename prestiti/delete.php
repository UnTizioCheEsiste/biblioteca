<?php
require_once("../connect.php");

$msg = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_copia = $_POST["id_copia"];
    $matricola = $_POST["matricola"];
    $data_uscita = $_POST["data_uscita"];

    $query = "
        DELETE FROM Prestito
        WHERE id_copia = '$id_copia' AND matricola = '$matricola' AND data_uscita = '$data_uscita'
    ";

    if (mysqli_query($connection, $query)) {
        $msg = "<div class='success'>✅ Prestito eliminato con successo.</div>";
    } else {
        $msg = "<div class='error'>Errore durante l'eliminazione: " . mysqli_error($connection) . "</div>";
    }
}

$prestiti = [];
$query_prestiti = "
    SELECT 
        P.id_copia,
        P.matricola,
        P.data_uscita,
        L.titolo,
        L.ISBN,
        U.nome,
        U.cognome
    FROM Prestito P
    JOIN CopiaLibro C ON P.id_copia = C.id_copia
    JOIN Libro L ON C.ISBN = L.ISBN
    JOIN Utente U ON P.matricola = U.matricola
    ORDER BY P.data_uscita DESC
";
$res = mysqli_query($connection, $query_prestiti);
while ($row = mysqli_fetch_assoc($res)) {
    $prestiti[] = $row;
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Cancella Prestito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-bottom: 10px;
        }

        .container {
            width: 700px;
            margin: 20px auto;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        select {
            width: 100%;
            padding: 6px;
            margin-top: 5px;
        }

        .btn {
            margin-top: 20px;
            padding: 8px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #b52a37;
        }

        .success,
        .error {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Cancella Prestito</h2>

        <?= $msg ?>

        <form method="post">
            <label for="prestito">Seleziona un prestito da cancellare:</label>
            <select name="prestito" id="prestito" required onchange="splitPrestito(this.value)">
                <option value="">-- Seleziona un prestito --</option>
                <?php foreach ($prestiti as $p): ?>
                    <?php
                    $value = $p['id_copia'] . '|' . $p['matricola'] . '|' . $p['data_uscita'];
                    $label = "(Uscita: $p[data_uscita]) - {$p['titolo']} (ISBN: {$p['ISBN']}) - {$p['nome']} {$p['cognome']} ({$p['matricola']})";
                    ?>
                    <option value="<?= $value ?>"><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Hidden fields to be filled via JS -->
            <input type="hidden" name="id_copia" id="id_copia">
            <input type="hidden" name="matricola" id="matricola">
            <input type="hidden" name="data_uscita" id="data_uscita">

            <button type="submit" class="btn">Cancella Prestito</button>
        </form>
    </div>

    <script>
        function splitPrestito(val) {
            if (!val) return;
            const [id_copia, matricola, data_uscita] = val.split('|');
            document.getElementById('id_copia').value = id_copia;
            document.getElementById('matricola').value = matricola;
            document.getElementById('data_uscita').value = data_uscita;
        }
    </script>

</body>

</html>
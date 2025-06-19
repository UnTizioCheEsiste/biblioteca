<?php
require_once("../connect.php");

$msg = "";

$utenti = [];
$res_utenti = mysqli_query($connection, "SELECT matricola, nome, cognome FROM Utente ORDER BY cognome, nome");
while ($row = mysqli_fetch_assoc($res_utenti)) {
    $utenti[] = $row;
}

$copie = [];
$res_copie = mysqli_query($connection, "
    SELECT C.id_copia, C.ISBN, L.titolo, C.succursale
    FROM CopiaLibro C
    JOIN Libro L ON C.ISBN = L.ISBN
    WHERE C.id_copia NOT IN (
        SELECT id_copia FROM Prestito
        WHERE data_restituzione_prevista IS NULL
        OR data_restituzione_prevista >= CURDATE()
    )
");
while ($row = mysqli_fetch_assoc($res_copie)) {
    $copie[] = $row;
}

// Gestione invio form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricola = $_POST["matricola"];
    $id_copia = $_POST["id_copia"];
    $data_uscita = date('Y-m-d');
    $data_restituzione = $_POST["data_restituzione"] ?? "";

    if ($data_restituzione === "") {
        $data_restituzione = date('Y-m-d', strtotime("+30 days"));
    } else {
        if ($data_restituzione <= $data_uscita) {
            $msg = "<div class='error'>La data di restituzione deve essere successiva alla data di uscita.</div>";
        }
    }

    if ($msg === "") {
        $query = "
            INSERT INTO Prestito (id_copia, matricola, data_uscita, data_restituzione_prevista)
            VALUES ('$id_copia', '$matricola', '$data_uscita', '$data_restituzione')
        ";
        if (mysqli_query($connection, $query)) {
            $msg = "<div class='success'>✅ Prestito registrato con successo.</div>";
        } else {
            $msg = "<div class='error'>Errore: " . mysqli_error($connection) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Aggiungi Prestito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-bottom: 10px;
        }

        .container {
            width: 600px;
            margin: 20px auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        select,
        input[type="date"] {
            width: 100%;
            padding: 6px;
            margin-top: 5px;
        }

        .btn {
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #003459;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #00171F;
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
        <h2>Aggiungi Prestito</h2>

        <?= $msg ?>

        <form method="post">
            <label for="matricola">Utente:</label>
            <select name="matricola" id="matricola" required>
                <option value="">-- Seleziona un utente --</option>
                <?php foreach ($utenti as $u): ?>
                    <option value="<?= $u['matricola'] ?>">
                        <?= htmlspecialchars($u['cognome'] . " " . $u['nome'] . " (" . $u['matricola'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_copia">Libro (copia disponibile):</label>
            <select name="id_copia" id="id_copia" required>
                <option value="">-- Seleziona una copia disponibile --</option>
                <?php foreach ($copie as $c): ?>
                    <option value="<?= $c['id_copia'] ?>">
                        <?= htmlspecialchars($c['titolo'] . " (ISBN: " . $c['ISBN'] . ", succursale: " . $c['succursale'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="data_restituzione">Data restituzione prevista (opzionale):</label>
            <input type="date" name="data_restituzione" id="data_restituzione">

            <button type="submit" class="btn">Registra Prestito</button>
        </form>
    </div>

</body>

</html>
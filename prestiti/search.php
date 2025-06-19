<?php
require_once("../connect.php");

$data_inizio = $_GET["data_inizio"] ?? "";
$data_fine = $_GET["data_fine"] ?? "";
$prestiti = [];

if ($data_inizio !== "" && $data_fine !== "") {
    $start = mysqli_real_escape_string($connection, $data_inizio);
    $end = mysqli_real_escape_string($connection, $data_fine);

    $query = "
        SELECT 
            P.data_uscita,
            P.data_restituzione_prevista,
            L.ISBN,
            L.titolo,
            U.matricola,
            U.nome,
            U.cognome
        FROM Prestito P
        JOIN CopiaLibro C ON P.id_copia = C.id_copia
        JOIN Libro L ON C.ISBN = L.ISBN
        JOIN Utente U ON P.matricola = U.matricola
        WHERE P.data_uscita BETWEEN '$start' AND '$end'
        ORDER BY P.data_uscita ASC
    ";
} else {
    $query = "
        SELECT 
            P.data_uscita,
            P.data_restituzione_prevista,
            L.ISBN,
            L.titolo,
            U.matricola,
            U.nome,
            U.cognome
        FROM Prestito P
        JOIN CopiaLibro C ON P.id_copia = C.id_copia
        JOIN Libro L ON C.ISBN = L.ISBN
        JOIN Utente U ON P.matricola = U.matricola
        WHERE P.data_restituzione_prevista >= CURDATE()
        ORDER BY P.data_restituzione_prevista ASC
    ";
}

$res = mysqli_query($connection, $query);
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $prestiti[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Ricerca Prestiti per Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        input[type="date"] {
            padding: 6px;
            margin-right: 10px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Ricerca Prestiti per Data</h2>

        <form method="get">
            <label for="data_inizio">Dal:</label>
            <input type="date" name="data_inizio" id="data_inizio" value="<?= htmlspecialchars($data_inizio) ?>">

            <label for="data_fine">Al:</label>
            <input type="date" name="data_fine" id="data_fine" value="<?= htmlspecialchars($data_fine) ?>">

            <button type="submit" class="btn">Cerca</button>
        </form>

        <h3>
            <?php if ($data_inizio !== "" && $data_fine !== ""): ?>
                Prestiti tra il <?= htmlspecialchars($data_inizio) ?> e il <?= htmlspecialchars($data_fine) ?>
            <?php else: ?>
                Prossimi prestiti in scadenza
            <?php endif; ?>
        </h3>

        <?php if (!empty($prestiti)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Titolo</th>
                        <th>Data Uscita</th>
                        <th>Restituzione Prevista</th>
                        <th>Matricola</th>
                        <th>Utente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestiti as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['ISBN']) ?></td>
                            <td><?= htmlspecialchars($p['titolo']) ?></td>
                            <td><?= htmlspecialchars($p['data_uscita']) ?></td>
                            <td><?= htmlspecialchars($p['data_restituzione_prevista']) ?></td>
                            <td><?= htmlspecialchars($p['matricola']) ?></td>
                            <td><?= htmlspecialchars($p['nome'] . " " . $p['cognome']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nessun prestito trovato.</p>
        <?php endif; ?>
    </div>

</body>

</html>
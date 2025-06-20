<?php
require_once("../connect.php");

$data_inizio = $_GET["data_inizio"] ?? "";
$data_fine = $_GET["data_fine"] ?? "";
$errore = "";
$statistiche = [];

if ($data_inizio !== "" && $data_fine !== "") {
    if ($data_fine < $data_inizio) {
        $errore = "La data di fine deve essere successiva o uguale alla data di inizio.";
    } else {
        $start = mysqli_real_escape_string($connection, $data_inizio);
        $end = mysqli_real_escape_string($connection, $data_fine);

        $query = "
            SELECT 
                C.succursale,
                COUNT(*) AS num_prestiti
            FROM Prestito P
            JOIN CopiaLibro C ON P.id_copia = C.id_copia
            WHERE P.data_uscita BETWEEN '$start' AND '$end'
            GROUP BY C.succursale
            ORDER BY num_prestiti DESC
        ";

        $res = mysqli_query($connection, $query);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $statistiche[] = $row;
            }
        }
    }
} elseif ($_GET) {
    $errore = "Inserisci entrambe le date per effettuare la ricerca.";
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Statistiche Prestiti per Succursale</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        input[type="date"] {
            padding: 6px;
            margin-right: 10px;
        }

        .btn {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 12px;
            background-color: #003459;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #00171F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
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

        .error {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Statistiche: Prestiti per Succursale</h2>

        <form method="get">
            <label for="data_inizio">Dal:</label>
            <input type="date" name="data_inizio" id="data_inizio" value="<?= htmlspecialchars($data_inizio) ?>" required>

            <label for="data_fine">Al:</label>
            <input type="date" name="data_fine" id="data_fine" value="<?= htmlspecialchars($data_fine) ?>" required>

            <button type="submit" class="btn">Mostra</button>
        </form>

        <?php if ($errore): ?>
            <div class="error"><?= $errore ?></div>
        <?php elseif (!empty($statistiche)): ?>
            <h3>Risultati dal <?= htmlspecialchars($data_inizio) ?> al <?= htmlspecialchars($data_fine) ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Succursale</th>
                        <th>Numero di Prestiti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statistiche as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['succursale']) ?></td>
                            <td><?= htmlspecialchars($s['num_prestiti']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_GET): ?>
            <p>Nessun prestito trovato nel periodo selezionato.</p>
        <?php endif; ?>

        <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
    </div>

</body>

</html>
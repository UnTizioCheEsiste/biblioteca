<?php
require_once("../connect.php");

$matricola = $_GET["matricola"] ?? "";
$prestiti = [];
$utente_nome = "";
$utente_cognome = "";

if ($matricola !== "") {
    $mat = mysqli_real_escape_string($connection, $matricola);

    $res_utente = mysqli_query($connection, "SELECT nome, cognome FROM Utente WHERE matricola = '$mat'");
    if ($res_utente && mysqli_num_rows($res_utente) > 0) {
        $utente = mysqli_fetch_assoc($res_utente);
        $utente_nome = $utente['nome'];
        $utente_cognome = $utente['cognome'];
    }

    $query = "
        SELECT 
            P.id_copia,
            P.data_uscita,
            P.data_restituzione_prevista,
            C.ISBN,
            L.titolo,
            P.data_restituzione_prevista < CURDATE() AS scaduto
        FROM Prestito P
        JOIN CopiaLibro C ON P.id_copia = C.id_copia
        JOIN Libro L ON C.ISBN = L.ISBN
        WHERE P.matricola = '$mat'
        ORDER BY P.data_uscita DESC
    ";

    $res = mysqli_query($connection, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $prestiti[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Storico Prestiti Utente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        input[type="text"] {
            padding: 6px;
            width: 200px;
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

        .in-corso {
            color: green;
            font-weight: bold;
        }

        .scaduto {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Storico Prestiti Utente</h2>

        <form method="get">
            <input type="number" name="matricola" placeholder="Matricola utente" value="<?= htmlspecialchars($matricola) ?>">
            <button type="submit" class="btn">🔍 Cerca</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>

        <?php if ($utente_nome && $utente_cognome): ?>
            <p><strong>Utente:</strong> <?= htmlspecialchars($utente_nome) ?> <?= htmlspecialchars($utente_cognome) ?> (<?= htmlspecialchars($matricola) ?>)</p>
        <?php elseif ($matricola !== ""): ?>
            <p><em>Nessun utente trovato con la matricola inserita.</em></p>
        <?php endif; ?>

        <?php if (!empty($prestiti)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Titolo</th>
                        <th>Data Uscita</th>
                        <th>Data Restituzione Prevista</th>
                        <th>Stato</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestiti as $p): ?>
                        <?php $stato = $p['scaduto'] ? 'Scaduto' : 'In corso'; ?>
                        <tr>
                            <td><?= htmlspecialchars($p['ISBN']) ?></td>
                            <td><?= htmlspecialchars($p['titolo']) ?></td>
                            <td><?= htmlspecialchars($p['data_uscita']) ?></td>
                            <td><?= htmlspecialchars($p['data_restituzione_prevista']) ?></td>
                            <td class="<?= $p['scaduto'] ? 'scaduto' : 'in-corso' ?>"><?= $stato ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($matricola !== "" && $utente_nome): ?>
            <p><em>L’utente non ha effettuato alcun prestito.</em></p>
        <?php endif; ?>
    </div>

</body>

</html>